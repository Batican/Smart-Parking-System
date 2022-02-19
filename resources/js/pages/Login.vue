<template>
    <v-app>
        <v-main>
            <v-container fill-height fluid>
                <v-row 
                    align="center" 
                    justify="center" 
                    dense
                >
                    <v-col 
                        cols="12"
                        sm="8"
                        md="4"
                        lg="4"    
                    >
                        <h1 class="text-center white--text">ADMIN LOGIN</h1>
                        <v-card elevation="0">
                            <v-card-text class="mt-12">
                                <v-form>
                                    <v-text-field
                                        color="light-yellow"
                                        v-model="form.email"
                                        label="Login"
                                        name="login"
                                        prepend-icon="person"
                                        type="text"
                                        class="rounded-0"
                                        outlined
                                    ></v-text-field>

                                    <v-text-field
                                        color="light-yellow"
                                        v-model="form.password"
                                        id="password"
                                        label="Password"
                                        name="password"
                                        prepend-icon="lock"
                                        class="rounded-0"
                                        outlined
                                        :type="show_pass ? 'text' : 'password'"
                                        :append-icon="show_pass ? 'mdi-eye' : 'mdi-eye-off'"
                                        @click:append="show_pass = !show_pass"
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions >
                                <v-spacer></v-spacer>
                                <v-btn color="#000000" class="rounded-0" x-large block dark @click="login_admin()">Login</v-btn>
                            </v-card-actions>
                            </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

    <!-- <div class="wrapper-container">
        sa login-form ibutang an img gamit bg-img 
        <div class="login-form"> 
             login form 
        </div>
    </div> 
    -->
</template>
<script>
export default {
    name: 'app',

    data: () => ({
        form : {
            email : 'admin@gmail.com',
            password : 1234,
        },
        show_pass : false
    }),
    methods : {
        login_admin() {
            axios.post('admin/login', this.form).then(({data}) => {
                if(data.token){
                    localStorage.setItem('token',data.token)
                    this.successNotify('Login');
                    this.$router.push('/dashboard')  
                }
            })
        }
    }
}
</script>
<style>
 #app {
    /* background: url('/images/bg_img.png')
        no-repeat center center !important;
    background-size: cover;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    transform: scale(1.1); */
    display: block;
    background: url(/images/bg_img.png) no-repeat;
    background-size: cover;
 }
 .v-application .mt-12 {
    padding: 40px 20px;
}
 </style>