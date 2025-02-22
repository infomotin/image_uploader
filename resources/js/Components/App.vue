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
            max-file-size="3MB"
            allow-multiple="true"
            max-files="1000"
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
import FilePondPluginFileValidateSize  from 'filepond-plugin-file-validate-size';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';

import axios from 'axios';

let serverMessages ={};
setOptions({
    server: {
        process: {
            url: './upload',
            onerror: (response) => {
                serverMessages = JSON.parse(response);
            },
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },

        }
    },
    labelFileProcessingError: (error, file) => {
        return serverMessages.error || 'Error processing file';
    }
});
const FilePond = VueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize,FilePondPluginImagePreview);

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