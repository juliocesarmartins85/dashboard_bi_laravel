<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="{{ asset(!empty(Auth::user()->foto) ? 'uploads/' . Auth::user()->foto : 'admin/assets/img/avatar.jpeg') }}"
                        alt="Profile" class="rounded-circle">
                    <h2>{{ $data['user']->name }}</h2>
                    <h3>{{ $data['user']->funcao }}</h3>
                    <div class="social-links mt-2">
                        <a href="{{ $data['user']->twitter }}" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="{{ $data['user']->facebook }}" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="{{ $data['user']->instagram }}" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="{{ $data['user']->linkedin }}" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Visão geral</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar
                                Perfil</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-settings">Configurações</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-change-password">Alterar a senha</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Sobre</h5>
                            <p class="small fst-italic">{{ $data['user']->desc }}</p>
                            <h5 class="card-title">Detalhes de perfil</h5>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Nome completo</div>
                                <div class="col-lg-9 col-md-8">{{ $data['user']->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Empresa</div>
                                <div class="col-lg-9 col-md-8">{{ $data['user']->empresa }}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Função</div>
                                <div class="col-lg-9 col-md-8">{{ $data['user']->funcao }}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">País</div>
                                <div class="col-lg-9 col-md-8">Brazil</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Endereço</div>
                                <div class="col-lg-9 col-md-8">{{ $data['user']->endereco }}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Telefone</div>
                                <div class="col-lg-9 col-md-8">{{ $data['user']->telefone }}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ $data['user']->email }}</div>
                            </div>
                        </div>
                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                            <!-- Profile Edit Form -->

                            <div class="row mb-3">
                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto</label>
                                <div class="col-md-8 col-lg-9">
                                    <img src="{{ asset(!empty(Auth::user()->foto) ? 'uploads/' . Auth::user()->foto : 'admin/assets/img/avatar.jpeg') }}"
                                        alt="Profile">
                                    <div class="pt-2">
                                        <form action="{{ route('file.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="inputFile">Foto:</label>
                                                <input type="file" name="file" id="inputFile"
                                                    class="form-control @error('file') is-invalid @enderror">
                                                @error('file')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-success">Enviar Foto</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('profile.update',Auth::user()->id) }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nome
                                        completo</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="fullName" type="text" class="form-control" id="fullName"
                                            value="{{ $data['user']->name }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="about" class="col-md-4 col-lg-3 col-form-label">Descrição</label>
                                    <div class="col-md-8 col-lg-9">
                                        <textarea name="about" class="form-control" id="about" style="height: 100px">{{ $data['user']->desc }}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="company" class="col-md-4 col-lg-3 col-form-label">Empresa</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="company" type="text" class="form-control" id="company"
                                            value="{{ $data['user']->organizacao }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Função</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="job" type="text" class="form-control" id="Job"
                                            value="{{ $data['user']->funcao }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Country" class="col-md-4 col-lg-3 col-form-label">Pais</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="country" type="text" class="form-control" id="Country"
                                            value="Brazil">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Address" class="col-md-4 col-lg-3 col-form-label">Endereço</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="address" type="text" class="form-control" id="Address"
                                            value="{{ $data['user']->endereco }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Telefone</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="phone" type="text" class="form-control" id="Phone"
                                            value="{{ $data['user']->telefone }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email"
                                            value="{{ $data['user']->email }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter
                                        Perfil</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="twitter" type="text" class="form-control" id="Twitter"
                                            value="{{ $data['user']->twitter }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook
                                        Perfil</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="facebook" type="text" class="form-control" id="Facebook"
                                            value="{{ $data['user']->facebook }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram
                                        Perfil</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="instagram" type="text" class="form-control" id="Instagram"
                                            value="{{ $data['user']->instagram }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin
                                        Perfil</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="linkedin" type="text" class="form-control" id="Linkedin"
                                            value="{{ $data['user']->linkedin }}">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                </div>
                            </form><!-- End Profile Edit Form -->
                        </div>
                        <div class="tab-pane fade pt-3" id="profile-settings">
                            <!-- Settings Form -->
                            <form>
                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email
                                        Notifications</label>
                                    <div class="col-md-8 col-lg-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                            <label class="form-check-label" for="changesMade">
                                                Alterações feitas em sua conta
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                            <label class="form-check-label" for="newProducts">
                                                Informações sobre novos produtos e serviços
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="proOffers">
                                            <label class="form-check-label" for="proOffers">
                                                Marketing e ofertas promocionais
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="securityNotify"
                                                checked disabled>
                                            <label class="form-check-label" for="securityNotify">
                                                Alertas de segurança
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                </div>
                            </form><!-- End settings Form -->
                        </div>
                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form>
                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Atual
                                        Senha</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control"
                                            id="currentPassword">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nova
                                        Senha</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="password" class="form-control"
                                            id="newPassword">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Digite novamente
                                        Senha</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="renewpassword" type="password" class="form-control"
                                            id="renewPassword">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Alterar Senha</button>
                                </div>
                            </form><!-- End Change Password Form -->
                        </div>
                    </div><!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
    </div>
</section>
