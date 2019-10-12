<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 row">
                <notifications position="top center" />
                <div class="col-md-5">
                    <form>
                        <div class="form-group col-md-12">
                            <label>Name:</label>
                            <input type="text" class="form-control form-control-xs" v-model="hobby.name">
                        </div>

                        <div class="form-group col-md-12">
                            <label>Category:</label>
                            <select v-model="hobby.category" class="form-control form-control-xs">
                                <option value="" selected="selected">Select a category</option>
                                <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Description:</label>
                            <textarea v-model="hobby.description" cols="30" rows="10" class="form-control form-control-xs"></textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <button class="btn btn-primary" type="submit" @click.prevent="saveHobby">
                                <span class="icon s7-diskette"></span>
                                <img src="/assets/loaders/Spinner.svg" alt="loading" v-if="loading"> Save
                            </button>
                            <button class="btn btn-danger" @click.prevent="hobby = {}"><span class="icon s7-close-circle"></span> Clear</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-7" v-if="viewHobbyView">
                    <div class="panel-heading">
                        All Hobbies
                        <div class="tools">
                            <span class="icon s7-refresh-2" @click.prevent="fetchAllHobbies"></span>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div v-if="viewallLoading">
                        </div>

                        <div v-if="!viewallLoading">
                            <!-- {{hobbies.length}} -->
                            <table class="table table-striped table-borderless" v-if="hobbies.length > 0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="no-border-x">
                                    <tr v-for="(hobby, index) in hobbies">
                                        <td>{{ ++index }}</td>
                                        <td>{{hobby.name}}</td>
                                        <td>{{hobby.category.name}}</td>
                                        <td>{{hobby.description}}</td>
                                        <td>
                                            <button class="icon text-primary btn btn-small " @click.prevent="editHobby(hobby)">edit</button>
                                            <button class="icon text-danger btn btn-small" @click.prevent="deleteHobby(hobby)">delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-else="">
                                <p class="text-danger text-center">No Hobby found</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7" v-if="editHobbyView">
                    <form>
                        Edit Hobby
                        <div class="form-group col-md-12">
                            <label>Name:</label>
                            <input type="text" class="form-control form-control-xs" v-model="currentSelectedHobby.name">
                        </div>

                        <div class="form-group col-md-12">
                            <label>Category:</label>
                            <select v-model="currentSelectedHobby.category" class="form-control form-control-xs">
                                <option value="">Select a category</option>
                                <option v-for="category in categories" :value="category.id" :selected="category.id === currentSelectedHobby.category.id">{{category.name}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Description:</label>
                            <textarea v-model="currentSelectedHobby.description" cols="30" rows="10" class="form-control form-control-xs"></textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <button class="btn btn-primary" type="submit" @click.prevent="updateHobby">
                                <span class="icon s7-diskette"></span>
                                <img src="/assets/loaders/Spinner.svg" alt="loading" v-if="loading"> Update
                            </button>
                            <button class="btn btn-danger" @click.prevent="editHobbyView = false; viewHobbyView = true"><span class="icon s7-close-circle"></span> Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {apiDomain} from '../env.js';
import { async } from 'q';
export default {
    data(){
        return {
            hobby: {},
            loading: false,
            viewallLoading: true,
            hobbies:[],
            user:{},
            categories:[],
            currentSelectedHobby:{},
            editHobbyView:false,
            viewHobbyView:true
        }
    },

    methods:{
        saveHobby () {
            this.loading = true;
            console.log(this.hobby);
            axios.post(apiDomain + '/hobby/create', this.hobby).then(response => {
                let $_response = response.data;
                console.log("here", response);
                if ($_response.status === 0) {
                    this.$notify({type: 'success', text: 'Hobby has been added successfully'});
                    this.fetchAllHobbies();
                } else {
                    this.$notify({type: 'error', text: 'Could not create hobby. Please try again'});
                }
                this.loading = false;
            }).catch(error => {
                this.loading = false;
                this.$notify({type: 'error', text: 'Could not create hobby. Please try again'});
            })
        },
        fetchAllHobbies: async function () {
            // this.viewallLoading = true;
            axios.get(apiDomain + '/hobby/get').then(response => {
                let $_response = response.data;
                if ($_response.status === 0) {
                    this.hobbies = $_response.data;
                    console.log(this.hobbies)
                    // this.viewallLoading = false;
                } else {
                    // this.$notify({type: 'error', text: 'Could not fetch hobbies. Try reloading this page'});
                }
                // this.viewallLoading = false;
                // console.log(this.viewallLoading);
            }).catch(error => {
                // this.viewallLoading = false;
                // this.$notify({type: 'error', text: 'Could not fetch hobbies. Please try again'});
            })
        },
        fetchAllCategories: async function () {
            // this.viewallLoading = true;
            axios.get(apiDomain + '/hobby/categories').then(response => {
                let $_response = response.data;
                if ($_response.status === 0) {
                    this.categories = $_response.data;
                    // this.viewallLoading = false;
                } else {
                    // this.$notify({type: 'error', text: 'Could not fetch categories. Try reloading this page'});
                }
                // this.viewallLoading = false;
                // console.log(this.viewallLoading);
            }).catch(error => {
                // this.viewallLoading = false;
                // this.$notify({type: 'error', text: 'Could not fetch categories. Please try again'});
            })
        },
        getAuthUser: async function() {
            axios.get(apiDomain + '/auth-user').then(response => {
            let $_response = response.data;
                if ($_response) {
                    this.user = JSON.parse($_response.data);
                }
            }).catch(error => {
                // this.$notify({type: 'error', text: 'No authenticated user found.'});
            })
        },
        editHobby(hobby){
            this.currentSelectedHobby = hobby;
            this.editHobbyView = true;
            this.viewHobbyView = false;
        },
        updateHobby(){
            this.currentSelectedHobby.category = this.currentSelectedHobby.category.id;
            axios.put(apiDomain + '/hobby/update', this.currentSelectedHobby).then(response => {
                let $_response = response.data;
                console.log($_response);
                if ($_response.status === 0) {
                    this.$notify({type: 'success', text: 'Hobby has been update successfully'});
                    this.fetchAllHobbies();
                    this.viewallLoading = false;
                } else {
                    this.viewallLoading = false;
                    this.$notify({type: 'error', text: 'Could not update hobby. Try reloading this page'});
                }
            }).catch(error => {
                this.viewallLoading = false;
                this.$notify({type: 'error', text: 'Could not update hobby. Please try again'});
            })
        },
        deleteHobby(hobby){
            axios.delete(apiDomain + '/hobby/delete/'+ hobby.id).then(response => {
                let $_response = response.data;
                console.log($_response);
                if ($_response.status === 0) {
                    this.$notify({type: 'success', text: 'Hobby has been deleted successfully'});
                    this.fetchAllHobbies();
                    this.viewallLoading = false;
                } else {
                    this.viewallLoading = false;
                    this.$notify({type: 'error', text: 'Could not delete hobby. Try reloading this page'});
                }
            }).catch(error => {
                this.viewallLoading = false;
                this.$notify({type: 'error', text: 'Could not delete hobby. Please try again'});
            })
        }
    },
    async mounted(){
        await this.fetchAllHobbies();
        await this.getAuthUser();
        await this.fetchAllCategories();
        this.viewallLoading = false;
    },
    components:{},
    props:[]
}
</script>
