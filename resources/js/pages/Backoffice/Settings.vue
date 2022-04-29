<template>
    <v-container>
        <v-card width="100%" color="#e1ad01">
            <v-card-title class="font-weight-bold">
                Generate Daily Report
            </v-card-title>
                <v-btn color="success" class="ml-15"  @click="downloadPDF()">
                    Generate
                </v-btn>


            <v-divider elevation="10"></v-divider>
            <v-card-title class="font-weight-bold">
                Configuration
            </v-card-title>



        </v-card>
    </v-container>
</template>
<script>
    export default {
         mounted(){
            this.downloadPDF()
            
        },

        methods: {
           downloadPDF()
                    {
                this.$admin.get('/admin/v1/generate-pdf',{
                    responseType: 'arraybuffer'
                    })
                    .then(response => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'DAILYREPORTS.pdf');
                        document.body.appendChild(link);
                        link.click();
                        // let blob = new Blob([response.data], { type: 'application/pdf' }),
                        // url = window.URL.createObjectURL(blob)

                        // window.open(url) // Mostly the same, I was just experimenting with different approaches, tried link.click, iframe and other solutions
                    })
            }
        }
    }
   

</script>