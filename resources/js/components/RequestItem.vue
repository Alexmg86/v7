<template>
    <li>
        <div class="level-2">
            <div class="flex items-center" @click="openLevel">
                <span class="icon">
                </span>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </span>
                <span class="ml-1">{{request.name}}</span>
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
            :isRequest="true"
            v-on:menuShowAction="openMenu"
            v-on:renameAction="renameAction"
            v-on:removeAction="removeAction"
        ></menu-list>
    </li>
</template>

<script>
    import MenuList from './MenuList'

    export default {
        props: ['request', 'index'],
        components: {
            MenuList
        },
        data() {
            return {
                isClosed: true,
                isMenu: false
            }
        },
        methods: {
            openLevel() {
                this.isClosed = !this.isClosed
            },
            openMenu() {
                this.isMenu = !this.isMenu
            },
            renameAction() {
                this.$emit('renameAction', 'request', this.request);
                this.openMenu();
            },
            removeAction() {
                this.$emit('removeAction', 'request', this.request);
                this.openMenu();
            }
        }
    }
</script>
