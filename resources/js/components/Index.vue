<template>
    <div class="h-screen inner-box flex">
        <div v-show="modalVisible" class="h-screen w-full absolute flex items-center justify-center bg-modal">
            <div class="bg-white rounded shadow modal text-center">
                <div class="mb-8">
                    <p class="modal-title">Create project!</p>
                </div>
                <div class="mb-8">
                    <input class="input border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-gray-200" placeholder="Enter project name" v-model="modalValue">
                </div>
                <div class="flex justify-between">
                    <button class="bg-gray-300 px-4 py-2 rounded text-white focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-opacity-50 modal-btn" @click="modalShow">Cancel</button>
                    <button class="bg-green-500 px-4 py-2 rounded text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 modal-btn"
                        @click="createProject"
                        :disabled="modalValue.length == 0"
                    >Create</button>
                </div>
            </div>
        </div>
        <div class="left-side">
            <div class="project-create flex flex-col items-center justify-center h-screen" @click="modalShow" v-if="projectsItems.length == 0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Create first project</p>
            </div>
            <ul class="project-list" v-else>
                <div class="flex items-center justify-end p-3 cursor-pointer" @click="modalShow">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <span class="ml-1">
                        Add project
                    </span>
                </div>
                <project-item 
                    v-for="(project, index) in projectsItems"
                    :project="project"
                    :key="index"
                    v-on:menuShowAction="menuShowAction"
                    :ref="'project-item-' + index"
                ></project-item>
            </ul>
        </div>
    </div>
</template>

<script>
    import ProjectItem from './ProjectItem'

    export default {
        props: ['projects'],
        components: {
            ProjectItem
        },
        data() {
            return {
                projectsItems: this.projects,
                modalVisible: false,
                menuShow: null,
                modalValue: ''
            }
        },
        methods: {
            createProject() {
                axios.post('/api', {
                    name: this.modalValue,
                    action: 'createProject'
                })
                .then(response => {
                    this.projectsItems.push(response.data);
                });
            },
            menuShowAction(key) {
                console.log(key);
                console.log('menuShowAction');
                this.menuShow = false;
            },
            modalShow() {
                this.modalVisible = !this.modalVisible
            }
        }
    }
</script>
