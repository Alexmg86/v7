<template>
    <div class="flex items-center mb-10 header-items">
        <div class="flex-initial">
            <div class="checkbox-c border border-gray-300 cursor-pointer" @click="checkItem">
                <svg v-if="isChecked" xmlns="http://www.w3.org/2000/svg" class="checkbox-inner" fill="none" viewBox="0 0 24 24" stroke="grey">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
        <div class="flex-auto ml-10">
            <input class="input small border border-gray-300 rounded" placeholder="name" ref="name" :value="header.name" @change="collectData">
        </div>
        <div class="flex-auto ml-10">
            <input class="input small border border-gray-300 rounded" placeholder="value" ref="value" :value="header.value" @change="collectData">
        </div>
        <div class="flex-initial ml-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="grey" @click="deleteHeader">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
    </div>
</template>

<script>

export default {
    props: ['header', 'index'],
    data() {
        return {
            isChecked: this.header.isChecked
        }
    },
    methods: {
        checkItem() {
            this.isChecked = !this.isChecked;
            this.collectData();
        },
        deleteHeader() {
            this.$emit('deleteHeader', this.index);
        },
        collectData() {
            const data = {
                'isChecked': this.isChecked,
                'name': this.$refs['name'].value,
                'value': this.$refs['value'].value
            }
            this.$emit('updateHeader', this.index, data);
        }
    }
}
</script>
