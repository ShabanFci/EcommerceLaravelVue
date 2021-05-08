<template>
    <div>
        <div class="row">
            <div class="col-md-4 product-box d-flex align-content-center justify-content-center flex-wrap big-text orders">
                <a href='/admin/orders'>Orders ({{orders.data.length}})</a>
            </div>
            <hr>
            <div class="col-md-4 product-box d-flex align-content-center justify-content-center flex-wrap big-text products">
                <a href='/admin/products'>Products ({{products.data.length}})</a>
            </div>
            <div class="col-md-4 product-box d-flex align-content-center justify-content-center flex-wrap big-text users">
                <a href='/admin/users'>Users ({{users.data.length}})</a>
            </div>
        </div>
        <table class="table table-responsive table-striped table-bordered">
                <h3 class="Text-center">Latest Not Delivered Orders</h3>
                <thead>

                    <tr>
                        <td></td>
                        <td>Product</td>
                        <td>Quantity</td>
                        <td>Cost</td>
                        <td>Delivery Address</td>
                        <td>is Delivered?</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>

                    <tr v-if="latestOrders.length == 0">
                        <td colspan="12" class="text-center">There Is No Not Delivered Orders Now</td>
                    </tr>
                    <tr v-for="(order,index) in latestOrders" @key="index">
                        <td>{{index+1}}</td>
                        <td v-html="order.product.name"></td>
                        <td>{{order.quantity}}</td>
                        <td>{{order.quantity * order.product.price}}</td>
                        <td>{{order.address}}</td>
                        <td>{{order.is_delivered == 1? "Yes" : "No"}}</td>
                        <td v-if="order.is_delivered == 0"><button class="btn" @click="deliver(index)">Deliver</button></td>
                        
                    </tr>
                </tbody>
            </table>
    </div>
    </template>

    <script>
    export default {
        data() {
            return {
                user : null,
                orders : [],
                latestOrders : [],
                products : [],
                users : []
            }
        },
        mounted() {
            axios.get('/api/users/').then(response => this.users = response.data)
            axios.get('/api/products/').then(response => this.products = response.data)
            axios.get('/api/orders/').then(response => this.orders = response.data)
            axios.get('/api/latestOrders').then(response => this.latestOrders = response.data)

        },
        methods: {
            deliver(index) {
                let order = this.latestOrders[index]
                axios.patch(`/api/orders/${order.id}/deliver`).then(response => {
                    this.latestOrders[index].is_delivered = 1
                    this.$forceUpdate()
                 axios.get('/api/latestOrders').then(response => this.latestOrders = response.data)    
                })

            }
        }
    }
    </script>

    <style scoped>
    .big-text { font-size: 28px; }
    .product-box { border: 1px solid #cccccc; padding: 20px 25px; height: 30vh;border:1px solid #fff;border-radius:20px;color: #fff }
    .orders{ background-color: #751c69}
    .products{ background-color: #b22979}
    .users{ background-color: #9a36bf}
    a{ text-decoration: none;color: #fff;font-weight: bold;}
    h3{ color: #888 ; padding: 10px}
    table{ border: 2px dashed #0a575a; border-radius: 25px;padding: 10px;margin:10px}
    .btn{background-color: #751c69;color:#fff}
    </style>