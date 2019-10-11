<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 row">
                <notifications position="top center" />
                <div class="col-md-5">
                    <form>
                        <div class="form-group col-md-12">
                            <label>Name:</label>
                            <input type="text" class="form-control form-control-xs" v-model="hobby.title">
                        </div>

                        <div class="form-group col-md-12">
                            <label>Category:</label>
                            <select v-model="hobby.category" class="form-control form-control-xs">
                                <option value="" selected="selected">Select a category</option>
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

                <div class="col-md-7">
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
                            {{hobbies.length}}
                            <table class="table table-striped table-borderless" v-if="hobbies.length > 0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th style="width:40%;">Description</th>
                                    </tr>
                                </thead>
                                <tbody class="no-border-x">
                                    <tr v-for="(hobby, index) in hobbies">
                                        <td>{{ ++index }}</td>
                                        <td>{{hobby.name}}</td>
                                        <td>{{hobby.category.name}}</td>
                                        <td>{{hobby.description}}</td>
                                        <td>
                                            <button v-if="book.author.id == user.id" class="icon text-danger btn btn-small" @click.prevent="deleteHobby(hobby)">delete</button>
                                            <button v-if="book.author.id != user.id" class="icon text-danger btn btn-small" disabled @click.prevent="deleteHobby(hobby)">delete</button>
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
            </div>
        </div>
    </div>
</template>
<script>
import {apiDomain} from '../env.js';
export default {
    data(){
        return {
            hobby: {},
            loading: false,
            viewallLoading: true,
            hobbies:[],
            user:{}
        }
    },

    methods:{
        saveHobby () {
            alert("here");
            this.loading = true;
            console.log(this.hobby);
            axios.post(apiDomain + '/hobby/create', this.hobby).then(response => {
                let $_response = response.data;
                console.log("here", response);
                if ($_response.status === 0) {
                    this.$notify({type: 'success', text: 'Hobby has been added successfully'});
                    this.fetchAllBooks();
                } else {
                    this.$notify({type: 'error', text: 'Could not create hobby. Please try again'});
                }
                this.loading = false;
            }).catch(error => {
                this.loading = false;
                this.$notify({type: 'error', text: 'Could not create hobby. Please try again'});
            })
        },
        fetchAllHobbies() {
            this.viewallLoading = true;
            axios.get(apiDomain + '/hobby/get').then(response => {
                let $_response = response.data;
                if ($_response.status === 0) {
                    this.hobbies = $_response.data;
                    this.viewallLoading = false;
                } else {
                    this.$notify({type: 'error', text: 'Could not fetch hobbies. Try reloading this page'});
                }
                this.viewallLoading = false;
                console.log(this.viewallLoading);
            }).catch(error => {
                this.viewallLoading = false;
                this.$notify({type: 'error', text: 'Could not fetch hobbies. Please try again'});
            })
        },
        getAuthUser(){
            axios.get(apiDomain + '/auth-user').then(response => {
            let $_response = response.data;
                if ($_response) {
                    this.user = JSON.parse($_response.data);
                    console.log(this.user);
                }
            }).catch(error => {
                this.$notify({type: 'error', text: 'No authenticated user found.'});
            })
        },
        deleteHobby(hobby){
            axios.delete(apiDomain + '/hobby/delete',  hobby).then(response => {
                let $_response = response.data;
                console.log($_response);
                if ($_response.status === 0) {
                    this.$notify({type: 'success', text: 'Hobby has been deleted successfully'});
                    this.fetchAllBooks();
                } else {
                    this.$notify({type: 'error', text: 'Could not delete hobby. Try reloading this page'});
                }
                this.viewallLoading = false;
            }).catch(error => {
                this.viewallLoading = false;
                this.$notify({type: 'error', text: 'Could not delete hobby. Please try again'});
            })
        }
    },
    mounted(){
        this.fetchAllHobbies();
        this.getAuthUser();
    },
    components:{},
    props:[]
}
</script>
