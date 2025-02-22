<template>
    <div>
        <div class="mt-4">

            <file-pond 
            name="image" 
            ref="filepond" 
            label-idle="Drop files here..." 
            @init="filePondInit"
            accepted-file-types="image/jpeg, image/png , image/jpg , image/gif"
            @processfile="handleProcessFile"
            />
        
        </div>
        <div class="mt-8 mb-24">
            <h3 class="text-2xl font-bold text-center">Images Gallery </h3>
            <div class="grid grid-cols-3 gap-4 mt-4 justify-evenly">
                <div v-for="image in images" :key="image.id" class="bg-gray-200 p-4">
                    <img :src="'/storage/images/' +image" alt="image" class="w-full h-64 object-cover">
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import VueFilePond, { setOptions } from 'vue-filepond';
import 'filepond/dist/filepond.min.css';

import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import axios from 'axios';

setOptions({
    server: {
        process: {
            url: './upload',
           
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },

        }
    },
});
const FilePond = VueFilePond(FilePondPluginFileValidateType);

export default {
    components: {
        FilePond
    },
    data() {
        return {
            images: []
        }
    },
    mounted() {
        
        axios.get('/showimages')
            .then(response => {
                this.images = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
    methods: {
        filePondInit() {
            // console.log('FilePond has initialized', this.$refs.filepond);

        },
        handleProcessFile(error,file) {
            if(error){
                console.log('error',error);
                return;
            }
            //add the uploaded image to the images array
            this.images.unshift(file.serverId);
        }
    }
}

</script>