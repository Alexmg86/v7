<template>
    <div class="select-box">
        <input class="input border border-gray-300 rounded"
        @click="openMenu"
        v-model="selectedValue"
        >
        <ul class="select-list shadow" v-if="isOpen" v-click-outside="onClickOutside">
            <li v-for="(option) in options" @click="getValue(option)">{{option}}</li>
        </ul>
    </div>
</template>

<script>

export default {
    props: ['options', 'selected'],
    data() {
        return {
            selectedValue: this.selected,
            isOpen: false
        }
    },
    methods: {
        openMenu() {
            this.isOpen = !this.isOpen;
        },
        onClickOutside() {
            this.openMenu();
        },
        getValue(id) {
            this.selectedValue = id;
            this.openMenu();
        }
    }
}
</script>
