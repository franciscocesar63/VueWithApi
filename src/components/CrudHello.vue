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
        /><br />
        <input
          type="text"
          class="form-control"
          name="idade"
          v-model="idade"
          placeholder="Idade"
        />
      </div>
      <input
        type="submit"
        value="Cadastrar"
        v-on:click.prevent="cadastrarUsuario()"
      />
    </form>
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
    };
  },
  methods: {
    cadastrarUsuario() {
      if (this.name !== "" && this.idade !== "") {
        var fd = new FormData();

        fd.append("nome", this.nome);
        fd.append("idade", this.idade);

        axios({
          url: "src/backend/cadastro.php",
          method: "post",
          data: fd,
        })
          .then((res) => {
            console.log(res);
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
  },
};
</script>