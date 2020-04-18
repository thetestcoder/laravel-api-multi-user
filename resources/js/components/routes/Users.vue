<template>
  <div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <button
            class="btn btn-primary btn-round"
            data-toggle="modal"
            data-target="#add-user"
          >Add New User</button>
        </div>

        <delete-modal :deleteItem="deleteUser"></delete-modal>

        <pop-modal
          title="Add New User"
          id="add-user"
          v-bind:saveData="saveUser"
          :btn-title="!is_update ? 'Save User': 'Update User'"
          v-bind:onClose="onClose"
        >
          <input-modal
            id="name"
            label-text="User Name"
            placeholder="Enter User Name"
            type="text"
            v-model="data.name"
          ></input-modal>
          <p v-if="errors.name" class="text-danger text-small">{{errors.name[0]}}</p>
          <input-modal
            id="email"
            label-text="User Email"
            placeholder="Enter Email ID"
            type="email"
            v-model="data.email"
          ></input-modal>
          <p v-if="errors.email" class="text-danger text-small">{{errors.email[0]}}</p>
          <input-modal
            v-if="!is_update"
            id="password"
            label-text="User Password"
            placeholder="Enter User Password"
            type="text"
            v-model="data.password"
          ></input-modal>
          <p v-if="errors.password" class="text-danger text-small">{{errors.password[0]}}</p>
          <div>
            <label for="role">Select Role</label>
            <select name="role_id" id="role" v-model="data.role_id" class="form-control">
              <option
                v-for="role in roles"
                :value="role.id"
                :key="role.id"
              >{{role.name.toUpperCase()}}</option>
            </select>
          </div>
          <p v-if="errors.role_id" class="text-danger text-small">{{errors.role_id[0]}}</p>
        </pop-modal>

        <!-- change password modal -->
        <pop-modal
          title="Change Password"
          id="change-password"
          v-bind:saveData="changePassword"
          btn-title="Change Password"
          v-bind:onClose="onClose"
        >
          <input-modal
            id="password"
            label-text="User Password"
            placeholder="Enter User Password"
            type="text"
            v-model="data.password"
          ></input-modal>
          <p v-if="errors.password" class="text-danger text-small">{{errors.password[0]}}</p>
        </pop-modal>

        <div class="col-md-12">
          <h3 class="border-bottom border-primary">Users</h3>
          <div>
            <table class="table table-bordered table-hover">
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
              <tr v-for="user in users.data" :key="user.id">
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.roles[0].name}}</td>
                <td>{{user.created_at}}</td>
                <td>
                  <button
                    class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#change-password"
                    @click="onChangePass(user.id)"
                  >Change Password</button>
                  <button
                    class="btn btn-warning btn-sm"
                    data-toggle="modal"
                    data-target="#add-user"
                    @click="onEdit(user.id)"
                  >Edit</button>
                  <button
                    class="btn btn-danger btn-sm"
                    data-toggle="modal"
                    data-target="#delete"
                    @click="wantToDelete(user.id)"
                  >Delete</button>
                </td>
              </tr>
            </table>
            <pagination :data="users" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import PopModal from "../modals/popup-modal";
import InputModal from "../modals/input.vue";
import Pagination from "laravel-vue-pagination";
import DeleteModal from "../modals/delete";
export default {
  components: {
    PopModal,
    InputModal,
    Pagination,
    DeleteModal
  },
  data() {
    return {
      temp_id: "",
      errors: [],
      users: {},
      roles: [],
      is_update: false,
      data: {
        id: 0,
        name: "",
        email: "",
        password: "",
        role_id: ""
      }
    };
  },
  created() {
    this.fetchUsers();
    this.fetchRoles();
  },
  methods: {
    getResults(page = 1) {
      axios.get("/admin/fetch/users?page=" + page).then(response => {
        this.users = response.data;
      });
    },
    fetchUsers() {
      axios.get("/admin/fetch/users").then(res => {
        this.users = res.data;
      });
    },
    fetchRoles() {
      axios.get("/admin/fetch/all-roles").then(res => {
        this.roles = res.data;
      });
    },

    onClose() {
      this.errors = [];
      this.is_update = false;
      this.data.name = "";
      this.data.password = "";
      this.data.role_id = "";
      this.data.email = "";
      this.temp_id = "";
    },
    onEdit(id) {
      this.onClose();
      axios.get("/admin/user/fetch/" + id).then(res => {
        this.data.id = res.data.id;
        this.data.name = res.data.name;
        this.data.email = res.data.email;
        this.data.role_id = res.data.roles[0].id;
        this.is_update = true;
      });
    },
    saveUser() {
      if (this.is_update) {
        var method = axios.put;
        var url = "/admin/user/update";
      } else {
        var method = axios.post;
        var url = "/admin/user/create";
      }
      method(url, this.data)
        .then(res => {
          this.onClose();
          this.$root.closeModal("#add-user");
          this.fetchUsers();
        })
        .catch(err => {
          if (err.response.status == 422)
            this.errors = err.response.data.errors;
        });
    },
    changePassword() {
      axios
        .put("/admin/user/change-password", this.data)
        .then(res => {
          this.onClose();
          this.$root.closeModal("#change-password");
        })
        .catch(err => {
          if (err.response.status == 422) {
            this.errors = err.response.data.errors;
          }
        });
    },
    onChangePass(id) {
      this.data.id = id;
    },
    wantToDelete(temp_id) {
      this.temp_id = temp_id;
    },
    deleteUser() {
      axios.delete("/admin/user/delete/" + this.temp_id).then(res => {
        this.onClose();
        this.fetchUsers();
        this.$root.closeModal("#delete");
      });
    }
  }
};
</script>