import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css' 
Vue.use(Vuetify)

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary: '#F2C904', 
                secondary: '#171200',
                accent: '#D5EEBB',
                error: '#f53851',
                info: '#2196F3',
                success: '#27b460',
                warning: '#ffc409',
            },
        },
        icons: {
            iconfont: 'mdi',
          },
    },
})