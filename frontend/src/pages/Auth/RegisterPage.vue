<template>
  <q-page class="flex flex-center">
    <q-card style="width: 500px; max-width: 100%;">
      <q-card-section>
        <div class="row q-col-gutter-sm">
          <div class="col col-12 title">
            <q-img src="~assets/logo.png" style="height: 150px;" class="q-mb-md" fit="contain"/>
          </div>
          <div class="col col-md-6 col-sm-12 col-xs-12">
            <div>First Name</div>
            <q-input dense filled v-model="first_name" />
          </div>
          <div class="col col-md-6 col-sm-12 col-xs-12">
            <div>Last Name</div>
            <q-input dense filled v-model="last_name" />
          </div>
          <div class="col col-12">
            <div>E-mail</div>
            <q-input dense filled type="email" v-model="email" />
          </div>
          <div class="col col-12">
            <div>Password</div>
            <q-input dense filled v-model="password" type="text" />
          </div>
          <div class="col col-12">
            <q-btn @click="register" color="primary" class="full-width q-mt-sm" label="Register" />
            <div class="q-mt-md">
              <span>Already have an account? </span>
              <span class="text-bold text-primary cursor-pointer" @click="$router.push('/login')">Login</span>
            </div>
          </div>
        </div>
      </q-card-section>

      <q-inner-loading :showing="loading">
        <q-spinner color="primary" />
      </q-inner-loading>
    </q-card>
  </q-page>
</template>

<script>
export default {
  name: 'RegisterPage',
  data () {
    return {
      loading: false,
      first_name: '',
      last_name: '',
      email: '',
      password: ''
    }
  },
  methods: {
    register () {
      const app = this
      app.loading = true

      const data = new FormData()
      data.append('data', JSON.stringify({
        first_name: app.first_name,
        last_name: app.last_name,
        email: app.email,
        password: app.password
      }))

      app.$axios.post(app.$s.api + 'api/v1/auth/register', data)
        .then(function (response) {
          localStorage.token = response.data.token
          app.$s.user = response.data.user
          app.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token
          app.$router.push('/dashboard')
        })
        .catch(function (error) {
          app.notify(error.response.data.message)
        })
        .finally(function () {
          app.loading = false
        })
    }
  }
}
</script>

<style scoped>
.title {
  text-align: center;
  padding: 10px 0;
}
</style>
