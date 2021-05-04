<template>
    <li>
        <div class="level-1">
            <div class="flex items-center" @click="openLevel">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor" v-if="this.requestItems.length > 0 || this.folderItems.length > 0">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" v-if="isClosed" />
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" v-else/>
                    </svg>
                </span>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </span>
                <span class="ml-1">{{project.name}}</span>
            </div>
            
            <span class="dots-level-1 flex items-center justify-center" @click="openMenu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </span>
        </div>
        <menu-list 
        :isMenu="isMenu" 
        v-on:menuShowAction="openMenu"
        v-on:menuAddAction="addFolder"
        v-on:menuAddRequest="addRequest"
        v-on:renameAction="renameAction"
        v-on:removeAction="removeAction"
        ></menu-list>
        <div v-if="!isClosed">
            <ul class="folder-list" v-if="this.folderItems.length > 0">
                <folder-item 
                v-for="(folder, index) in folderItems"
                :folder="folder"
                :index="index"
                v-on:menuAddRequest="addRequest"
                v-on:renameAction="renameAction"
                v-on:removeAction="removeAction"
                ></folder-item>
            </ul>
            <ul class="folder-list" v-if="this.requestItems.length > 0">
                <request-item 
                v-for="(request, index) in requestItems"
                :request="request"
                :index="index"
                v-on:menuAddRequest="addRequest"
                v-on:renameAction="renameAction"
                v-on:removeAction="removeAction"
                ></request-item>
            </ul>
        </div>
    </li>
</template>

<script>
    import FolderItem from './FolderItem'
    import RequestItem from './RequestItem'
    import MenuList from './MenuList'

    export default {
        props: ['project', 'index'],
        components: {
            FolderItem,
            RequestItem,
            MenuList
        },
        data() {
            return {
                isClosed: true,
                isMenu: false,
                folderItems: this.project.folders,
                requestItems: this.project.items
            }
        },
        methods: {
            openLevel() {
                this.isClosed = !this.isClosed
            },
            openMenu() {
                this.isMenu = !this.isMenu
            },
            addRequest(folderId) {
                this.$emit('addAction', 'request', this.project.id, folderId);
                if (!folderId) {
                    this.openMenu();
                }
            },
            addFolder() {
                this.$emit('addAction', 'folder', this.project.id);
                this.openMenu();
            },
            renameAction(type, item) {
                if (!item) {
                    item = this.project;
                    type = 'project';
                    this.openMenu();
                }
                this.$emit('renameAction', type, item, this.project.id);
            },
            removeAction(type, item) {
                if (!item) {
                    item = this.project;
                    type = 'project';
                    this.openMenu();
                } else {
                    if (type == 'folder') {
                        this.folderItems = this.folderItems.filter((e) => e.id !== item.id );
                    } else if (type == 'request') {
                        this.requestItems = this.requestItems.filter((e) => e.id !== item.id );
                    }
                }
                this.$emit('removeAction', type, item, this.project.id);
            }
        },
        watch: {
            project: function (val) {
                this.folderItems = val.folders
                this.requestItems = val.items
            }
        }
    }
</script>
