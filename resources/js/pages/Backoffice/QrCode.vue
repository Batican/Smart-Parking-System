<template>
    <div class="container" >
        <div  v-html="slot">
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                slot: {}
            }
        },

        mounted(){
            this.generate()
        },

        methods: {
            
            generate(){
                this.$admin.get(`/admin/v1/parking_slot/qrcode/${this.$route.params.id}`).then(({data}) => {
                        this.slot = data
                });
            }

        }
    }
</script>