<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function checkout(Request $request) {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $products = json_decode($request->getContent());
        $lineItems = [];
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->price * $product->quantity;
            $lineItems[] = [
                'price_data' => [
                    'currency' => $product->currency_code,
                    'product_data' => [
                        'name' => $product->name,
                        'images' => [$product->image]
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $product->quantity,
            ];
        }
        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true)."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => $request->header('origin'),
            'customer_creation' => "always"
        ]);

        foreach ($products as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->name = $product->name;
            $orderProduct->description = $product->description;
            $orderProduct->image = $product->image;
            $orderProduct->quantity = $product->quantity;
            $orderProduct->price = $product->price*100;
            $orderProduct->currency_code = $product->currency_code;
            $orderProduct->fk_session_id = $session->id;
            $orderProduct->save();
        }

        $order = new Order();
        $order->status = 'unpaid';
        $order->total_price = $totalPrice;
        $order->session_id = $session->id;
        $order->redirect_url = $request->header('origin');
        $order->save();

        return response(["url" => $session->url], 200);
    }

    public function success(Request $request) {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $session_id = $request->get('session_id');

        //try {
            $session = Session::retrieve($session_id);
            if (!$session) {
                throw new NotFoundHttpException;
            }
            $customer = Customer::retrieve($session->customer);

            $order = Order::where('session_id', $session->id)->first();
            if (!$order) {
                throw new NotFoundHttpException();
            }
            if ($order->status === 'unpaid') {
                $order->status = 'paid';
                $order->save();
            }

            $products = OrderProduct::all()->where('fk_session_id', $session_id);

            return view('product.checkout-success', compact('customer', 'order', 'products'));

        /*} catch (\Exception $e) {
            throw new NotFoundHttpException;
        }*/
    }

    public function cancel(Request $request) {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $session_id = $request->get('session_id');

        try {
            $session = Session::retrieve($session_id);
            if (!$session) {
                throw new NotFoundHttpException;
            }

            $order = Order::where('session_id', $session->id)->first();
            if (!$order) {
                throw new NotFoundHttpException();
            }

            return redirect($order->redirect_url);
        } catch (\Exception $e) {
            throw new NotFoundHttpException;
        }
    }

    public function webhook() {
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

// Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $sessionId = $session->id;

                $order = Order::where('session_id', $sessionId)->first();
                if ($order && $order->status === 'unpaid') {
                    $order->status = 'paid';
                    $order->save();
                }

            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('');
    }
}
