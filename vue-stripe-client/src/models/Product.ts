export default class Product {
    prod_id: string;
    name: string;
    description: string;
    image: string;
    price: number;
    currency_code: string;
    quantity: number

    constructor(prod_id: string, name: string, description: string, image: string, price: number, currency_code: string, quantity: number) {
        this.prod_id = prod_id;
        this.name = name;
        this.description = description;
        this.image = image;
        this.price = price;
        this.currency_code = currency_code;
        this.quantity = quantity;
    }
}
