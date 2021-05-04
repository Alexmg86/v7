<template>
    <div v-if="modalVisible" v-click-outside="modalShow" class="h-screen w-full absolute flex items-center justify-center bg-modal">
        <div class="bg-white rounded shadow modal text-center">
            <div class="mb-8">
                <p class="modal-title">Create {{modalTitle}}!</p>
            </div>
            <div class="mb-8">
                <input class="input border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-200"
                 :placeholder="'Enter ' + modalTitle + ' name'"
                 @keyup.enter="createSomething"
                 v-model="value"
                 ref='modalTitle'
            >
            </div>
            <div class="flex justify-between">
                <button class="bg-gray-300 px-4 py-2 rounded text-white focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-opacity-50 modal-btn" @click="modalShow">Cancel</button>
                <button class="bg-green-500 px-4 py-2 rounded text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 modal-btn"
                @click="createSomething"
                >Create</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['modalVisible', 'modalTitle'],
        data() {
            return {
                value: ''
            }
        },
        methods: {
            clearValue() {
                this.value = '';
            },
            createSomething() {
                if (this.value.length > 0) {
                    this.$emit('createSomething', this.value);
                    this.clearValue();
                }
            },
            modalShow() {
                this.$emit('modalShow');
                this.clearValue();
            }
        }
    }
</script>
