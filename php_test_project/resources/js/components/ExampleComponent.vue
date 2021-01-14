<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Avatar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td><img class="rounded-circle" :src="'/uploads/avatars/'+user.avatar" alt="Avatar" style="max-width: 50px; max-height: 50px;"></td>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ExampleComponent",
        data(){
            return {
                users:[],
            }
        },
        created(){
             axios.get(`/api/users`)
            .then((response)=>{
                this.users = response.data;
            });
        }
       
    }
</script>
