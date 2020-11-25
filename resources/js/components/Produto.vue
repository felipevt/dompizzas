<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card pt-2 pb-2">
                    <div class="card-header">
                        <div class="d-flex justify-content-inline">
                            <h3 class="card-title mt-2">Produtos</h3>
                            <p class="card-title mt-2 ml-5">
                                <span class="ml-5">Total de Produtos: {{resultCount}}</span>
                            </p>
                        </div>
                        <div class="card-tools mt-2">
                            <button class="btn btn-success" @click="createModal">
                                Novo Produto
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
                                <th scope="col">Descrição</th>
                                <th scope="col">Valor de Venda R$</th>
                                <th class="text-right" scope="col">Ações</th>
                            </tr>
                            </thead>
                            <tr v-for="produto in produtos.data" :key="produto.id">
                                <td scope="row">{{produto.nome|ucFirst}}</td>
                                <td>{{produto.descricao}}</td>
                                <td>{{produto.vlvenda}}</td>
                                <td class="text-right">
                                    <a href="#" @click="editModal(produto)">
                                        <i class="fa fa-edit green m-1"></i>
                                    </a>
                                    <a href="#" @click="deleteCategory(produto.id)">
                                        <i class="fa fa-trash red m-1"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
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
                        <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Cadastrar Produto</h5>
                        <h5 v-show="editMode" class="modal-title" id="addNewLabel">Atualizar Produto</h5>
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
                                        placeholder="Nome do Produto"
                                        :class="{ 'is-invalid': form.errors.has('nome') }"
                                >
                                <p></p>
                                <has-error :form="form" field="nome"></has-error>
                                <input
                                        v-model="form.descricao"
                                        type="text"
                                        name="descricao"
                                        class="form-control"
                                        placeholder="Descrição do produto"
                                        :class="{ 'is-invalid': form.errors.has('descricao') }"
                                >
                                <has-error :form="form" field="descricao"></has-error>
                                <p></p>
                                <input
                                        v-model="form.vlvenda"
                                        type="text"
                                        name="vlvenda"
                                        class="form-control"
                                        placeholder="Valor de venda"
                                        :class="{ 'is-invalid': form.errors.has('vlvenda') }"
                                >
                                <has-error :form="form" field="vlvenda"></has-error>
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
    </div>
</template>

<script>
    // import { setInterval } from "timers";
    export default {
        data() {
            return {
                editMode: false,
                produtos: {},
                form: new Form({
                    id: "",
                    nome: "",
                    descricao: "",
                    vlvenda: ""
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
            editModal(produto) {
                this.editMode = true;
                this.form.reset();
                this.form.clear();
                $("#addNew").modal("show");
                this.form.fill(produto);
            },

            loadCategories() {
                this.$Progress.start();
                axios
                    .get("api/produto")
                    .then(({ data }) => (this.produtos = data))
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
                this.$Progress.finish();
            },
            createCategory() {
                this.$Progress.start();
                this.form
                    .post("api/produto")
                    .then(() => {
                        $("#addNew").modal("hide");
                        Toast.fire({
                            type: "success",
                            title: "Produto criado com sucesso!"
                        });
                        this.$Progress.finish();
                        this.loadCategories();
                    })
                    .catch();
            },
            updateCategory() {
                this.$Progress.start();
                this.form
                    .put("api/produto/" + this.form.id)
                    .then(() => {
                        $("#addNew").modal("hide");
                        Swal.fire(
                            "Atualizado!",
                            "O produto foi atualizado com sucesso.",
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
                            .delete("api/produto/" + id)
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
                if (Object.keys(this.produtos).length == 0) {
                    return 0;
                }
                return Object.keys(this.produtos.data).length;
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
