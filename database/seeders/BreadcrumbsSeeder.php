<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreadcrumbsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DB::table('breadcrumbs')->insert([
        //    [
        //        'page' => 'internet-empresarial',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Internet Empresarial',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Produtos e Serviços|Internet Empresarial',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'internet-residencial',
        //        'title' => 'breadcrumbs',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Internet Residencial',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Produtos e Serviços|Internet Residencial',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'rastreador-veicular',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Rastreador Veicular',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Produtos e Serviços|Rastreador Veicular',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'tecnologias-para-cidades-digitais',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Cidades Digitais',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Produtos e Serviços|Cidades Digitais',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'politica-privacidade',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Politica De Privacidade',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Politica De Privacidade',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'diretiva-privacidade',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Diretiva De Privacidade',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Diretiva De Privacidade',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'ouvidoria',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Ouvidoria',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Ouvidoria',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'politica-de-cookies',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Politica De Cookie',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Politica De Cookie',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'lei-geral-de-protecao-de-dados',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Lei Geral de Proteção de Dados',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Lei Geral de Proteção de Dados',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'contato',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Contato',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Contato',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'empresa',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Empresa',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Empresa',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'sucesso',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Sucesso',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Sucesso',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'treinamento',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Treinamento Aplicativo',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Treinamento',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'estacao-movel',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Estaçao Móvel de Monitoramento',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Estaçao Móvel de Monitoramento',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'page' => 'blog',
        //        'title' => 'breadcrumbs',
        //        'bannerimg' => 'site/assets/img/banner-ono-tecnologia.jpg',
        //        'bannertitle' => 'Blog Onotecnologia',
        //        'bannerbody' => '',
        //        'breadcrumbs' => 'Home|Blog Onotecnologia',
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ]
        //]);
    }
}
