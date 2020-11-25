<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card pt-2 pb-2">
                    <div class="card-header">
                        <div class="d-flex justify-content-inline">
                            <h3 class="card-title mt-2">Clientes</h3>
                            <p class="card-title mt-2 ml-5">
                                <span class="ml-5">Total de Clientes: {{resultCount}}</span>
                            </p>
                        </div>
                        <div class="card-tools mt-2">
                            <button class="btn btn-success" @click="createModal">
                                Novo Cliente
                                <i class="fas fa-layer-group"></i>
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">

                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Telefone</th>
                                <th class="text-right" scope="col">Ações</th>
                            </tr>
                            </thead>
                            <tr v-for="cliente in clientes.data" :key="cliente.id">
                                <td scope="row">{{cliente.nome|ucFirst}}</td>
                                <td>{{cliente.email}}</td>
                                <td>{{cliente.telefone}}</td>
                                <td class="text-right">


                                    <a href="#" @click="readModal(cliente.id)">
                                        <i class="fa fa-eye blue m-1"></i>
                                    </a>
                                    <a href="#" @click="editModal(cliente)">
                                        <i class="fa fa-edit green m-1"></i>
                                    </a>
                                    <a href="#" @click="deleteCategory(cliente.id)">
                                        <i class="fa fa-trash red m-1"></i>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div
                class="modal fade"
                id="addNew"
                tabindex="-1"
                role="dialog"
                aria-labelledby="addNewLabel"
                aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Cadastrar Cliente</h5>
                        <h5 v-show="editMode" class="modal-title" id="addNewLabel">Atualizar Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cancelar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editMode ? updateCategory() : createCategory()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input
                                        v-model="form.nome"
                                        type="text"
                                        name="nome"
                                        class="form-control"
                                        placeholder="Nome do Cliente"
                                        :class="{ 'is-invalid': form.errors.has('nome') }"
                                >
                                <p></p>
                                <has-error :form="form" field="nome"></has-error>
                                <input
                                        v-model="form.email"
                                        type="text"
                                        name="email"
                                        class="form-control"
                                        placeholder="E-mail do Cliente"
                                        :class="{ 'is-invalid': form.errors.has('email') }"
                                >
                                <has-error :form="form" field="email"></has-error>
                                <p></p>
                                <input
                                    v-model="form.documento"
                                    type="text"
                                    name="documento"
                                    class="form-control"
                                    placeholder="CPF/CNPJ"
                                    :class="{ 'is-invalid': form.errors.has('documento') }"
                            >
                                <has-error :form="form" field="documento"></has-error>
                                <p></p>

                                <input
                                        v-model="form.telefone"
                                        type="text"
                                        name="telefone"
                                        class="form-control"
                                        placeholder="Telefone"
                                        :class="{ 'is-invalid': form.errors.has('telefone') }"
                                >
                                <has-error :form="form" field="telefone"></has-error>
                                <p></p>

                                <input
                                        v-model="form.endereco"
                                        type="text"
                                        name="endereco"
                                        class="form-control"
                                        placeholder="Endereço"
                                        :class="{ 'is-invalid': form.errors.has('endereco') }"
                                >
                                <has-error :form="form" field="endereco"></has-error>
                                <p></p>

                                <input
                                        v-model="form.cep"
                                        type="text"
                                        name="cep"
                                        class="form-control"
                                        placeholder="CEP"
                                        :class="{ 'is-invalid': form.errors.has('cep') }"
                                >
                                <has-error :form="form" field="cep"></has-error>
                                <p></p>

                                <input
                                        v-model="form.status"
                                        type="text"
                                        name="status"
                                        class="form-control"
                                        placeholder="Status"
                                        :class="{ 'is-invalid': form.errors.has('status') }"
                                >
                                <has-error :form="form" field="status"></has-error>
                                <p></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                            <button v-show="editMode" type="submit" class="btn btn-primary">Salvar</button>
                            <button v-show="!editMode" type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal de Visualização -------------------------------------->
        <div
                class="modal fade"
                id="showCliente"
                tabindex="-1"
                role="dialog"
                aria-labelledby="addNewLabel"
                aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewLabel">Dados do Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cancelar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <p>Nome: {{cliente1.nome}}</p>
                    <p>E-mail: {{cliente1.email}}</p>
                    <p>CPF/CNJP: {{cliente1.documento}}</p>
                    <p>Telefone: {{cliente1.telefone}}</p>
                    <p>Endereço: {{cliente1.endereco}}</p>
                    <p>CEP: {{cliente1.cep}}</p>
                    <p>Status: {{cliente1.status}}</p>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import { setInterval } from "timers";
    export default {
        props: ["id"],
        data() {
            return {
                editMode: false,
                clientes: {},
                cliente1: {},
                form: new Form({
                    id: "",
                    nome: "",
                    documento: "",
                    email: "",
                    telefone: "",
                    endereco: "",
                    cep: "",
                    status: ""
                })
            };
        },
        methods: {


            createModal() {
                this.editMode = false;
                this.form.reset();
                this.form.clear();
                $("#addNew").modal("show");
            },
            editModal(cliente) {
                this.editMode = true;
                this.form.reset();
                this.form.clear();
                $("#addNew").modal("show");
                this.form.fill(cliente);
            },
            readModal(id) {
                this.$Progress.start();
                this.form.reset();
                this.form.clear();
                $("#showCliente").modal("show");
                console.log(id);
                axios
                    .get("api/cliente/" + id)
                    .then(({ data }) => (this.cliente1 = data))
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
                console.log("buscou dado")

                this.$Progress.finish();



            },



            loadCategories() {
                this.$Progress.start();
                axios
                    .get("api/cliente")
                    .then(({ data }) => (this.clientes = data))
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
                console.log("carregou!")
                this.$Progress.finish();
            },
            createCategory() {
                this.$Progress.start();
                this.form
                    .post("api/cliente")
                    .then(() => {
                        $("#addNew").modal("hide");
                        Toast.fire({
                            type: "success",
                            title: "Cliente cadastrado com sucesso!"
                        });
                        this.$Progress.finish();
                        this.loadCategories();
                    })
                    .catch();
            },
            updateCategory() {
                this.$Progress.start();
                this.form
                    .put("api/cliente/" + this.form.id)
                    .then(() => {
                        $("#addNew").modal("hide");
                        Swal.fire(
                            "Atualizado!",
                            "O Cliente foi atualizado com sucesso.",
                            "success"
                        );
                    })
                    .catch();
                this.$Progress.finish();
                this.loadCategories();
            },
            deleteCategory(id) {
                Swal.fire({
                    title: "Você tem certeza?",
                    text: "Não será possível reverter esta ação!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Sim, pode apagar!"
                }).then(result => {
                    if (result.value) {
                        //Send delete req to controller
                        this.form
                            .delete("api/cliente/" + id)
                            .then(() => {
                                Swal.fire(
                                    "Excluído!",
                                    "O registro foi excluído.",
                                    "success"
                                );
                            })
                            .catch(() => {
                                Swal(
                                    "Erro!",
                                    "Há alguma coisa errada.",
                                    "warning"
                                );
                            });
                    }
                    this.loadCategories();
                });
            }
        },
        computed: {
            resultCount() {
                if (Object.keys(this.clientes).length == 0) {
                    return 0;
                }
                return Object.keys(this.clientes.data).length;
            }
        },
        mounted() {
            console.log("Component mounted.");
        },
        created() {
            this.loadCategories();

            // setInterval(() => this.loadCategories(), 4000);
        }
    };
</script>
