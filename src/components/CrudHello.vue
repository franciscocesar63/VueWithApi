<template>
  <div class="container">
    <form action="post">
      <div class="form-group">
        <h1>Cadastro de Usuário</h1>
        <br />
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
      <input
        type="submit"
        value="Cadastrar"
        class="btn btn-primary mt-2"
        v-on:click.prevent="cadastrarUsuario()"
      />
    </form>

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
            <a href="/" class="btn btn-info"> EDITAR</a>
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
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
    getUsuarios() {
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
      var fd = new FormData();

      fd.append("id", id);

      axios({
        url: "http://localhost/hellovue/src/backend/deleteUsuario.php",
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
  },

  mounted: function () {
    this.getUsuarios();
  },
};
</script>