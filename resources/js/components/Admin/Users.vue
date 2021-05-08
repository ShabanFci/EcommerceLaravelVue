<template>
        <div>
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <td></td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Joined</td>
                        <td>Total Orders</td>
                    
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user,index) in users.data" @key="index">
                        <td>{{index+1}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.created_at}}</td>
                        <td>{{user.orders.length}}</td>
                       
                    </tr>
                </tbody>
            </table>

             <br>
  <pagination class="justify-content-center pagination" :data="users" @pagination-change-page="getResults"></pagination>
        </div>
    </template>

    <script>
    export default {
        data() {
            return {
                users : []
            }
        },
        beforeMount() {
            this.getResults()
            
        },
        methods: {

            getResults(page= 1){
                
             axios.get('/api/users?page=' + page).then(response => this.users = response.data)
            }
    }
}
    </script>
    <style scoped>
     .btn{background-color: #751c69;color:#fff}
     table{border: 2px solid #0a575a;border-radius:25px}
    </style>