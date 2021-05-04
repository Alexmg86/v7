<template>
    <li>
        <div class="level-2">
            <div class="flex items-center" @click="openLevel">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor" v-if="this.requestItems.length > 0">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" v-if="isClosed" />
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" v-else/>
                    </svg>
                </span>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </span>
                <span class="ml-1">{{folder.name}} - {{index}}</span>
            </div>
            
            <span class="dots-level-2 flex items-center justify-center" @click="openMenu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </span>
        </div>
        <menu-list 
            :isMenu="isMenu" 
            :isFolder="true" 
            v-on:menuShowAction="openMenu"
            v-on:menuAddRequest="addRequest"
            v-on:renameAction="renameAction"
            v-on:removeAction="removeItem"
        ></menu-list>
        <div v-if="!isClosed">
            <ul class="request-list" v-if="this.requestItems.length > 0">
                <request-item 
                v-for="(request, index) in requestItems"
                :request="request"
                :index="index"
                v-on:renameAction="renameAction"
                ></request-item>
            </ul>
        </div>
    </li>
</template>

<script>
    import RequestItem from './RequestItem'
    import MenuList from './MenuList'

    export default {
        props: ['folder', 'index'],
        components: {
            RequestItem,
            MenuList
        },
        data() {
            return {
                isClosed: true,
                isMenu: false,
                requestItems: this.folder.items
            }
        },
        methods: {
            openLevel() {
                this.isClosed = !this.isClosed
            },
            openMenu() {
                this.isMenu = !this.isMenu
            },
            addRequest() {
                this.$emit('menuAddRequest', this.folder.id);
                this.openMenu();
            },
            renameAction(type, item) {
                if (!item) {
                    item = this.folder;
                    type = 'folder';
                    this.openMenu();
                }
                this.$emit('renameAction', type, item);
            },
            removeItem() {
                this.$emit('removeAction', this.project.id);
                this.openMenu();
            }
        },
        watch: {
            folder: function (val) {
                this.requestItems = val.items
            }
        }
    }
</script>
