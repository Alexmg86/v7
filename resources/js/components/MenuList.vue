<template>
    <ul class="menu-level-1" v-if="isMenu" v-click-outside="onClickOutside">
        <li class="flex items-center" @click="addFolder" v-if="!isFolder && !isRequest">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            add folder
        </li>
        <li class="flex items-center" @click="addRequest" v-if="!isRequest">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            add request
        </li>
        <li class="flex items-center" @click="renameItem">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
            rename
        </li>
        <li class="flex items-center" @click="removeItem">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            remove
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['isMenu', 'isFolder', 'isRequest'],
        methods: {
            addFolder() {
                this.$emit('menuAddAction');
            },
            addRequest() {
                this.$emit('menuAddRequest');
            },
            renameItem() {
                this.$emit('renameAction');
            },
            removeItem() {
                this.$emit('removeAction');
            },
            onClickOutside() {
                this.$emit('menuShowAction');
            }
        }
    }
</script>
