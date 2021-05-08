<template>
        <div>
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <td></td>
                        <td>Product</td>
                        <td>Units</td>
                        <td>Price</td>
                        <td>Description</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product,index) in products.data" @key="index" >
                        <td>{{index+1}}</td>
                        <td v-html="product.name"></td>
                        <td v-model="product.units">{{product.units}}</td>
                        <td v-model="product.price">{{product.price}}</td>
                        <td v-model="product.price">{{product.description}}</td>
                        <td><button class="btn delete" @click="deleteProduct(index)">Delete</button></td>
                        <td><button class="btn btn-primary" @click="editingItem = product">Edit</button></td>

                    </tr>
                
                </tbody>
            </table>
            <modal @close="endEditing" :product="editingItem" v-show="editingItem != null"></modal>
            <modal @close="addProduct"  :product="addingProduct" v-show="addingProduct != null"></modal>
            <br>
            <button class="btn add-pro" @click="newProduct">Add New Product</button>
            <br>
  <pagination class="justify-content-center pagination" :data="products" @pagination-change-page="getResults"></pagination>
        </div>
    </template>

    <script>
    import Modal from './ProductModal'

    export default {
        data() {
            return {
                products: [],
                editingItem: null,
                addingProduct: null
            }
        },
        components: {Modal},
        beforeMount() {
            this.getResults()
            
        },
        methods: {

            getResults(page= 1){
                
             axios.get('/api/products?page=' + page).then(response => this.products = response.data)
            },
            newProduct() {
                this.addingProduct = {
                    name: null,
                    units: null,
                    price: null,
                    image: null,
                    description: null,
                }
            },
            endEditing(product) {
                this.editingItem = null

                let index = this.products.indexOf(product)
                let name = product.name
                let units = product.units
                let price = product.price
                let description = product.description

                axios.put(`/api/products/${product.id}`, {name, units, price, description})
                     .then(response => this.products[index] = product)
            },
            addProduct(product) {
                this.addingProduct = null

                let name = product.name
                let units = product.units
                let price = product.price
                let description = product.description
                let image = product.image 

                axios.post("/api/products/", {name, units, price, description, image})
                     .then(response => this.products.push(product))
            },
            
            deleteProduct(index) {
                let product = this.products.data[index]
                axios.delete(`/api/products/${product.id}`)
                axios.get('/api/products/').then(response => this.products = response.data)
        }

        }
    }
    </script>
    <style scoped>
     .add-pro{background-color: #751c69;color:#fff}
     table{border: 2px solid #0a575a;border-radius:25px}
     .delete{ background-color: #e3342f}
     .btn{ color: #fff}
    </style>