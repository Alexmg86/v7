<template>
    <div class="select-box">
        <input class="input small border border-gray-300 rounded" @click="openMenu" :value="selectedValue">
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
        getValue(option) {
            if (this.selectedValue != option) {
                this.$emit('changed');
            }
            this.selectedValue = option;
            this.openMenu();
        }
    },
    watch: {
        selected: function (val) {
            this.selectedValue = val
        }
    },
}
</script>
