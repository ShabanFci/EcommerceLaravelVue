 <template>
        <div>
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <td></td>
                        <td>Product</td>
                        <td>Quantity</td>
                        <td>Cost</td>
                        <td>Delivery Address</td>
                        <td>is Delivered?</td>
                        <td>Created at</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(order,index) in orders.data" @key="index">
                        <td>{{index+1}}</td>
                        <td v-html="order.product.name"></td>
                        <td>{{order.quantity}}</td>
                        <td>{{order.quantity * order.product.price}}</td>
                        <td>{{order.address}}</td>
                        <td>{{order.is_delivered == 1? "Yes" : "No"}}</td>
                        <td>{{order.created_at}}</td>
                        <td v-if="order.is_delivered == 0"><button class="btn" @click="deliver(index)">Deliver</button></td>
                    </tr>
                </tbody>
            </table>
            <br>
  <pagination class="justify-content-center pagination" :data="orders" @pagination-change-page="getResults"></pagination>
        </div>
    </template>

    <script>
    export default {
        data() {
            return {
                orders : []
            }
        },
        beforeMount(){
            this.getResults()
            
        },
        methods: {
            getResults(page= 1){
                
             axios.get('/api/orders?page=' + page).then(response => this.orders = response.data)
            },

            deliver(index) {
                let order = this.orders.data[index]
                axios.patch(`/api/orders/${order.id}/deliver`).then(response => {
                    this.orders[index].is_delivered = 1
                    this.$forceUpdate()
                    
                    

                })
                 axios.get('/api/orders/').then(response => this.orders = response.data)
            }
        }
    }
    </script>
    <style scoped>
     .btn{background-color: #751c69;color:#fff}
     table{border: 2px solid #0a575a;border-radius:25px}
    </style>