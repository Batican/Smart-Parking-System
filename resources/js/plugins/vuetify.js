import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
Vue.use(Vuetify)

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary: '#5F7A61', 
                secondary: '#7FC8A9',
                accent: '#D5EEBB',
                error: '#f53851',
                info: '#2196F3',
                success: '#27b460',
                warning: '#ffc409',
            },
        },
    },
})