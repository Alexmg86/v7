<template>
    <div class="h-screen inner-box flex">
        <create-modal 
            ref="modal"
            :modalVisible="modalVisible"
            :modalTitle="modalTitle"
            v-on:createSomething="createSomething"
            v-on:modalShow="modalShow"
        ></create-modal>
        <div class="left-side overflow-y-auto">
            <div class="project-create flex flex-col items-center justify-center h-screen" @click="modalShow('project')" v-if="projectsItems.length == 0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Create first project</p>
            </div>
            <ul class="project-list" v-else>
                <div class="flex items-center justify-end p-3 cursor-pointer" @click="modalShow('project')">
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
                    :index="index"
                    v-on:addAction="addAction"
                    v-on:renameAction="renameAction"
                    v-on:removeAction="removeAction"
                ></project-item>
            </ul>
        </div>
    </div>
</template>

<script>
    import ProjectItem from './ProjectItem'
    import CreateModal from './CreateModal'

    export default {
        props: ['projects'],
        components: {
            ProjectItem,
            CreateModal
        },
        data() {
            return {
                projectsItems: this.projects,
                modalVisible: false,
                isEdit: false,
                modalTitle: '',
                modalValue: '',
                selectedProject: null,
                selectedFolder: null,
                selectedRequest: null
            }
        },
        methods: {
            clearSelected() {
                this.selectedProject = null;
                this.selectedFolder = null;
                this.selectedRequest = null;
                this.isEdit = false;
            },
            createSomething(value) {
                let type = this.modalTitle;
                axios.post('/api', {
                    project_id: this.selectedProject,
                    folder_id: this.selectedFolder,
                    request_id: this.selectedRequest,
                    name: value,
                    type: this.modalTitle,
                    isEdit: this.isEdit,
                    action: 'createOrUpdateItem'
                })
                .then(response => {
                    if (type == 'project') {
                        this.newProject(response.data);
                    }
                    if (type == 'folder') {
                        this.newFolder(response.data);
                    }
                    if (type == 'request') {
                        this.newRequest(response.data);
                    }
                    this.$nextTick(function () {
                        this.clearSelected();
                    })
                });
                this.modalShow();
            },
            newProject(data) {
                if (this.isEdit) {
                    let projectIndex = _.findIndex(this.projectsItems, ['id', this.selectedProject]);
                    this.projectsItems[projectIndex] = data;
                } else {
                    this.projectsItems.push(data);
                }
            },
            newFolder(data) {
                var project = _.find(this.projectsItems, ['id', this.selectedProject]);
                let projectIndex = _.findIndex(this.projectsItems, ['id', this.selectedProject]);
                if (this.isEdit) {
                    let folderIndex = _.findIndex(project.folders, ['id', this.selectedFolder]);
                    project.folders[folderIndex] = data;
                } else {
                    project.folders.push(data);
                }
                this.projectsItems[projectIndex] = project;
            },
            newRequest(data) {
                var project = _.find(this.projectsItems, ['id', this.selectedProject]);
                let projectIndex = _.findIndex(this.projectsItems, ['id', this.selectedProject]);

                if (this.selectedFolder) {
                    var folder = _.find(project.folders, ['id', this.selectedFolder]);
                    let folderIndex = _.findIndex(project.folders, ['id', this.selectedFolder]);
                    if (this.isEdit) {
                        let itemIndex = _.findIndex(folder.items, ['id', this.selectedRequest]);
                        folder.items[itemIndex] = data;
                    } else {
                        folder.items.push(data);
                    }
                    project.folders[folderIndex] = folder;
                } else {
                    if (this.isEdit) {
                        let itemIndex = _.findIndex(project.items, ['id', this.selectedRequest]);
                        project.items[itemIndex] = data;
                    } else {
                        project.items.push(data);
                    }
                }
                this.projectsItems[projectIndex] = project;
            },
            addAction(type, projectId, folderId) {
                this.selectedProject = projectId;
                this.selectedFolder = folderId;
                this.modalShow(type);
            },
            renameAction(type, item, projectId) {
                this.modalShow(type, item.name);
                this.isEdit = true;
                if (type == 'project') {
                    this.selectedProject = projectId;
                }
                if (type == 'folder') {
                    this.selectedProject = projectId;
                    this.selectedFolder = item.id;
                }
                if (type == 'request') {
                    this.selectedProject = projectId;
                    this.selectedFolder = item.folder_id;
                    this.selectedRequest = item.id;
                }
            },
            removeAction(type, item, projectId) {
                if (type == 'project') {
                    this.projectsItems = this.projectsItems.filter((e) => e.id !== item.id );
                }
                axios.post('/api', {
                    id: item.id,
                    type: type,
                    action: 'deleteItem'
                });
            },
            modalShow(value, name) {
                this.modalVisible = !this.modalVisible;
                this.modalTitle = value;
                if (this.modalVisible) {
                    this.$nextTick(() => {
                        this.$refs.modal.$refs.modalTitle.focus();
                        if (name) {
                            this.$refs.modal.$refs.modalTitle.value = name;
                        }
                    });
                }
            }
        }
    }
</script>
