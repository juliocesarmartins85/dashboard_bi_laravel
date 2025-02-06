<?php

namespace Database\Seeders;

use App\Models\Web;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Web::create([
            "url" => "https://www.fonelight.com.br",
            "emp" => "Fonelight",
            "name" => "Plano Livre Fonelight Fibra - Até 500 Mega de velocidade!",
            "desc" => "Internet residencial Fonelight Fibra: Banda larga com fibra óptica de até 500 Mega de velocidade. Navegue à vontade com a internet livre de Varginha. Assine já!",
            "endereco" => "Praça Champagnat, 19 - Centro - Varginha/MG<br/>CEP: 37002-150<br/>",
            "telefonefixo" => "(35) 3221-6626",
            "telefone0800" => "0800 404 1010",
            "telefone" => "35 97601-0202",
            "locale" => "pt-br",
            "root" => "",
            "whatsappnum" => "(35) 9 7601-020",
            "whatsapp" => "https://api.whatsapp.com/send?phone=553532216626&text=" . htmlentities('Gostaria de ser atendido via whatsapp!'),
            "favicon" => "web/assets/img/site/favicon.png",
            "logo" => "web/assets/img/site/fonelight/logo-fonelight-fibra.svg",
            "email" => "contato@fonelight.com.br",
            "areacliente" => "#",
            "form_contact" => json_encode([
                [
                    'name' => 'nome',
                    'icon' => 'bi bi-person',
                    'title' => 'Nome',
                    'input' => 'input',
                    'type' => 'text',
                    'col' => '6',
                ],
                [
                    'name' => 'telefone',
                    'icon' => 'bi bi-phone',
                    'title' => 'Telefone',
                    'input' => 'input',
                    'type' => 'tel',
                    'col' => '6',
                ],
                [
                    'name' => 'email',
                    'icon' => 'bi bi-envelope',
                    'title' => 'Email',
                    'input' => 'input',
                    'type' => 'email',
                    'col' => '12',
                ],
                [
                    'name' => 'mensagem',
                    'icon' => '',
                    'title' => 'Mensagem',
                    'input' => 'textarea',
                    'type' => 'text',
                    'col' => '12',
                ],
            ]),
            "quem_somos" => json_encode([
                [
                    'h2' => 'A História',
                    'p' => 'Nossa história teve início em 1997 com atuação na área de serviços. Após as privatizações das
                    companhias de
                    telecomunicações realizadas pelo governo Brasileiro, abriu-se mercado para novas empresas atuarem no mercado
                    de
                    Telecom. Desta forma, o Grupo FoneLight que é uma S/A de capital fechado, possui outorgas da ANATEL em SCM
                    (Serviço de Comunicação Multimídia)
        e SeAC (Serviço de Acesso Condicionado) para explorar seus serviços em
                    todo
                    território nacional, atuando com Telefonia Digital, Internet de alta velocidade via fibra óptica, internet
                    via
                    Satélite e internet móvel 4G com cobertura em mais de 3 mil cidades no Brasil, TV via Satélite DTH e
                    Rastreamento veicular, oferecendo produtos e serviços com alta tecnologia atendendo desde usuários finais
                    até
                    empresas de grande porte. Nosso grande diferencial é a qualidade dos serviços e atendimento personalizado,
                    oferecendo aos nossos usuários uma experiência inigualável. O investimento nas marcas também é de grande
                    importância para nossos gestores, pois visa garantir a divulgação dos principais produtos do Grupo. Temos
                    muito
                    orgulho da alta qualidade de nossos produtos e dos recursos disponibilizados em cada segmento, mas nos
                    orgulhamos ainda mais da valorização do elemento humano presente em todos os momentos das nossas operações.
                    É da
                    aliança entre tecnologia e criatividade que extraímos nossas estratégias de mercado.'
                ],
                [
                    'h2' => 'A Missão',
                    'p' => 'Nossa missão é proporcionar ao mercado brasileiro serviços de alta qualidade de maneira
                    inovadora,
                    customizada,
                    com atendimento diferenciado e soluções eficazes, construindo uma relação de parceria, respeito e confiança
                    com
                    nossos clientes e fornecedores.'
                ],
                [
                    'h2' => 'Os Valores',
                    'p' => 'Buscamos desenvolvimento profissional de nossos colaboradores e valorizamos o relacionamento com nossos
                        clientes de maneira respeitosa e comprometida.',
                ],
                [
                    'h2' => 'Nossos Objetivos',
                    'p' => 'Temos como objetivo e metas, disponibilizar produtos que combinam inovação, tecnologia,
                    qualidade e
                    profissionalismo.'
                ],
            ]),
            "asset_web" => json_encode([
                "css" => [
                    'web/assets/vendor/fontawesome-free/css/all.min.css',
                    'web/assets/vendor/animate.css/animate.min.css',
                    'web/assets/vendor/aos/aos.css',
                    'web/assets/vendor/boxicons/css/boxicons.min.css',
                    'web/assets/vendor/glightbox/css/glightbox.min.css',
                    'web/assets/vendor/swiper/swiper-bundle.min.css',
                    'web/css/variables.css',
                    'web/css/style.css'
                ],
                "js" => [
                    'web/assets/vendor/purecounter/purecounter_vanilla.js',
                    'web/assets/vendor/aos/aos.js',
                    'web/assets/vendor/glightbox/js/glightbox.min.js',
                    'web/assets/vendor/swiper/swiper-bundle.min.js',
                    'web/js/main.js'
                ],
                "font" => [
                    'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i',
                    'https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100;200;300;400;500;600;700;800;900&display=swap'
                ]
            ]),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
