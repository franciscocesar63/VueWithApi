<template>
  <div class="container">
    <div>
      <b-button
        id="show-btn"
        @click="showModal"
        v-on:click.prevent="editFalse"
        class="mt-5 mb-5"
        >Cadastrar Usuário</b-button
      >

      <b-modal ref="my-modal" hide-footer title="Cadastro de Usuário">
        <div class="d-block text-center">
          <form action="post">
            <div class="form-group">
              <br />
              <input
                v-show="edit"
                type="text"
                class="form-control"
                name="id"
                v-model="id"
                placeholder="ID"
                disabled
              />
              <input
                type="text"
                class="form-control"
                name="nome"
                v-model="nome"
                placeholder="Nome"
              />
              <input
                type="text"
                class="form-control mt-2"
                name="idade"
                v-model="idade"
                placeholder="Idade"
              />
            </div>
          </form>
        </div>

        <b-button
          v-show="!edit"
          class="mt-2"
          variant="outline-success"
          block
          @click="hideModal"
          v-on:click.prevent="cadastrarUsuario()"
          >Cadastrar</b-button
        >
        <b-button
          v-show="edit"
          class="mt-2"
          variant="outline-success"
          block
          @click="hideModal"
          v-on:click.prevent="editarUsuario(id, nome, idade)"
          >Editar</b-button
        >
        <b-button
          class="mt-3"
          v-on:click.prevent="cancelarCadastro"
          variant="outline-danger"
          block
          @click="hideModal"
          >Cancelar</b-button
        >
      </b-modal>
    </div>

    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Idade</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in usuarios" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.nome }}</td>
          <td>{{ user.idade }}</td>
          <td>
            <a
              v-on:click.prevent="deleteUsuario(user.id)"
              class="btn btn-danger"
            >
              DELETE</a
            >
            <a
              href="/"
              class="btn btn-info"
              v-on:click.prevent="changeEdit(user.id)"
            >
              EDITAR</a
            >
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "CrudHello",

  data() {
    return {
      nome: "",
      idade: "",
      id: "",
      usuarios: [],
      edit: false,
    };
  },

  methods: {
    cadastrarUsuario() {
      if (this.name !== "" && this.idade !== "") {
        var fd = new FormData();

        fd.append("nome", this.nome);
        fd.append("idade", this.idade);

        axios({
          url: "http://localhost/hellovue/src/backend/cadastro.php",
          method: "post",
          data: fd,
        })
          .then((res) => {
            console.log(res);
            this.getUsuarios();
            this.hideModal();
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        alert("Por favor, preencha todos os dados de cadastro");
        this.hideModal();
      }
    },
    getUsuarios() {
      this.edit = false;
      axios({
        url: "http://localhost/hellovue/src/backend/getUsuarios.php",
        method: "get",
      })
        .then((res) => {
          console.log(res.data);
          this.usuarios = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deleteUsuario(id) {
      this.edit = false;
      var fd = new FormData();

      fd.append("id", id);

      axios({
        url: "http://localhost/hellovue/src/backend/delete.php",
        method: "post",
        data: fd,
      })
        .then((res) => {
          console.log(res);
          this.getUsuarios();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    changeEdit(id) {
      this.edit = true;

      this.id = id;

      var fd = new FormData();

      fd.append("id", id);

      axios({
        url: "http://localhost/hellovue/src/backend/getUsuarioByID.php",
        method: "post",
        data: fd,
      })
        .then((res) => {
          this.nome = res.data["nome"];
          this.idade = res.data["idade"];
        })
        .catch((err) => {
          console.log(err);
        });

      this.showModal();
    },
    editarUsuario(id, nome, idade) {
      var fd = new FormData();
      fd.append("id", id);
      fd.append("nome", nome);
      fd.append("idade", idade);

      console.log(fd);
      axios({
        url: "http://localhost/hellovue/src/backend/updateUsuario.php",
        method: "post",
        data: fd,
      })
        .then((res) => {
          if (res.data == "sucess") {
            this.hideModal();
            this.getUsuarios();
          }
        })
        .catch((err) => {
          console.log(err);
        });

      this.edit = false;
      this.id = "";
      this.nome = "";
      this.idade = "";
    },

    showModal() {
      this.$refs["my-modal"].show();
    },
    hideModal() {
      this.edit = false;
      this.$refs["my-modal"].hide();
    },
    editTrue() {
      this.edit = true;
    },
    editFalse() {
      this.edit = false;
    },
    cancelarCadastro() {
      this.id = "";
      this.nome = "";
      this.idade = "";
      this.editFalse();
    },
  },

  mounted: function () {
    this.getUsuarios();
  },
};
</script>