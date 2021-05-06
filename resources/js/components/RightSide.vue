<template>
    <div class="right-side">
        <div class="box-inner w-full shadow-sm">
            <div class="grid grid-cols-12 flex items-center box-inner-mb">
                <p class="col-span-10 item-name">{{item.name}}</p>
                <button class="col-span-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-opacity-50 justify-self-end item-btn">Save</button>
            </div>
            <div class="grid grid-cols-12 flex items-center">
                <div class="col-span-2">
                    <select-list :options="options" :selected="item.method" ref="selectList"></select-list>
                </div>
                <div class="col-span-8">
                    <input class="input border border-gray-300 rounded"
                        placeholder="Type an URL"
                        :value="item.url"
                        ref="selectUrl"
                    >
                </div>
                <button class="col-span-2 bg-blue-500 rounded text-white focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-opacity-50 justify-self-end item-btn" @click="updateRequest">Send</button>
            </div>
        </div>
    </div>
</template>

<script>
    import selectList from './Select';

    export default {
        props: ['item'],
        components: {
            selectList
        },
        data() {
            return {
                options: [
                    'GET',
                    'POST',
                    'DELETE'
                ],
                isChanged: false
            }
        },
        methods: {
            updateRequest() {
                let body = {
                    'method': this.$refs['selectList'].selectedValue,
                    'url': this.$refs['selectUrl'].value
                };
                this.$emit('updateRequest', this.item, body);
            }
        }
    }
</script>
