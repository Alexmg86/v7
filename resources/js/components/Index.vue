<template>
    <div class="h-screen inner-box flex">
        <div class="left-side">
            ddd
        </div>
    </div>
</template>

<script>
    export default {
        props: [],
        data() {
            return {
                isChat: true,
                isParamChat: true,
                userSex: 0,
                userAge: 0,
                findSex: 1,
                findAge: {
                    0: 0,
                    1: 0,
                    2: 0,
                    3: 0,
                },
            }
        },
        methods: {
            startChat() {
                this.isChat = !this.isChat
                this.isParamChat = !this.isParamChat
            },
            selectUserSex(val) {
                this.userSex = val
            },
            selectFindSex(val) {
                this.findSex = val
            },
            selectUserAge(val) {
                this.userAge = val
            },
            selectFindAge(val) {
                this.findAge[val] = !this.findAge[val]
            }
        }
    }
</script>
