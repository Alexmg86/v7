<template>
    <div class="right-side overflow-y-auto">
        <div class="box-inner w-full shadow-sm">

            <div class="flex items-center mb-10">
                <div class="flex-auto item-name">{{item.name}}</div>
                <div class="flex-initial">
                    <button class="col-span-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-opacity-50 justify-self-end item-btn ml-10" @click="updateRequest">
                        Save
                        <span class="ischange bg-blue-500" v-if="isChanged"></span>
                    </button>
                </div>
            </div>

            <div class="flex items-end mb-10">
                <div class="flex-initial">
                    <p class="label">Method</p>
                    <select-list :options="options" :selected="item.method" ref="selectList" v-on:changed="changed"></select-list>
                </div>
                <div class="flex-auto">
                    <p class="label">Url</p>
                    <input class="input small border border-gray-300 rounded" placeholder="Type an URL" v-model="url" ref="selectUrl" @change="changed">
                </div>
                <div class="flex-initial">
                    <button class="col-span-2 bg-blue-500 rounded text-white focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-opacity-50 justify-self-end item-btn-md">Send</button>
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="pad-r-5">
                    <p class="label">Headers</p>
                    <header-item 
                    v-for="(header, index) in headers" 
                    :index="index"
                    :header="header"
                    v-on:updateHeader="updateHeader"
                    v-on:deleteHeader="deleteHeader"
                    ></header-item>
                    <button class="col-span-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-opacity-50 justify-self-end item-btn" @click="addHeader">Add header</button>
                </div>
                <div class="pad-l-5">
                    <p class="label">Body</p>
                    <div class="request-box">
                        <prism-editor class="my-editor" v-model="code" :highlight="highlighter" line-numbers></prism-editor>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-inner w-full shadow-sm">
            <div class="flex items-center mb-10">
                <div class="flex-auto item-name">Response</div>
            </div>
        </div>
    </div>
</template>

<script>
    import selectList from './Select';
    import headerItem from './HeaderItem';
    import { PrismEditor } from 'vue-prism-editor';
    import 'vue-prism-editor/dist/prismeditor.min.css';

    import { highlight, languages } from 'prismjs/components/prism-core';

    import 'prismjs/components/prism-clike';
    import 'prismjs/components/prism-javascript';
    import 'prismjs/components/prism-json';
    import 'prismjs/themes/prism.css';

    export default {
        props: ['item'],
        components: {
            selectList,
            headerItem,
            PrismEditor
        },
        data() {
            return {
                options: [
                    'GET',
                    'POST',
                    'PUT',
                    'DELETE',
                    'HEAD',
                    'OPTIONS',
                    'PATCH'
                ],
                code: this.item.request,
                headers: this.item.headers,
                url: this.item.url,
                isChanged: false
            }
        },
        methods: {
            highlighter(code) {
                return highlight(code, languages.json);
            },
            addHeader() {
                this.headers.push({
                    'isChecked': true,
                    'name': '',
                    'value': ''
                });
                this.changed();
            },
            deleteHeader(index) {
                this.headers.splice(index, 1);
                this.changed();
            },
            updateHeader(index, data) {
                this.headers[index] = data;
                this.changed();
            },
            updateRequest() {
                let body = {
                    'method': this.$refs['selectList'].selectedValue,
                    'url': this.$refs['selectUrl'].value,
                    'headers': this.headers,
                    'request': this.code
                };
                this.$emit('updateRequest', this.item, body);
                this.isChanged = false
            },
            changed() {
                this.isChanged = true
            }
        },
        watch: {
            item: function (val) {
                this.headers = val.headers,
                this.url = val.url,
                this.code = val.request
            }
        },
    }
</script>
