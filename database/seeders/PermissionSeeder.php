<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'bairro-listar',
           'bairro-criar',
           'bairro-editar',
           'bairro-deletar',
           'breadcrumb-listar',
           'breadcrumb-criar',
           'breadcrumb-editar',
           'breadcrumb-deletar',
           'blog-listar',
           'blog-criar',
           'blog-editar',
           'blog-deletar',
           'combo-listar',
           'combo-criar',
           'combo-editar',
           'combo-deletar',
           'cliente-listar',
           'cliente-criar',
           'cliente-editar',
           'cliente-deletar',
           'faq-listar',
           'faq-criar',
           'faq-editar',
           'faq-deletar',
           'feature-listar',
           'feature-criar',
           'feature-editar',
           'feature-deletar',
           'srvcfeatured-listar',
           'srvcfeatured-criar',
           'srvcfeatured-editar',
           'srvcfeatured-deletar',
           'footer-listar',
           'footer-criar',
           'footer-editar',
           'footer-deletar',
           'grupo-listar',
           'grupo-criar',
           'grupo-editar',
           'grupo-deletar',
           'juridico-listar',
           'juridico-criar',
           'juridico-editar',
           'juridico-deletar',
           'menu-listar',
           'menu-criar',
           'menu-editar',
           'menu-deletar',
           'pricing-listar',
           'pricing-criar',
           'pricing-editar',
           'pricing-deletar',
           'ctrpricing-listar',
           'ctrpricing-criar',
           'ctrpricing-editar',
           'ctrpricing-deletar',
           'movelpricing-listar',
           'movelpricing-criar',
           'movelpricing-editar',
           'movelpricing-deletar',
           'sectionpage-listar',
           'sectionpage-criar',
           'sectionpage-editar',
           'sectionpage-deletar',
           'sidebar-listar',
           'sidebar-criar',
           'sidebar-editar',
           'sidebar-deletar',
           'tip-listar',
           'tip-criar',
           'tip-editar',
           'tip-deletar',
           'vantagen-listar',
           'vantagen-criar',
           'vantagen-editar',
           'vantagen-deletar',
           'video-listar',
           'video-criar',
           'video-editar',
           'video-deletar',
           'funcao-listar',
           'funcao-criar',
           'funcao-editar',
           'funcao-deletar',
           'banner-listar',
           'banner-criar',
           'banner-editar',
           'banner-deletar',
           'product-listar',
           'product-criar',
           'product-editar',
           'product-deletar',
           'usuario-listar',
           'usuario-criar',
           'usuario-editar',
           'usuario-deletar',
           'contact-listar',
           'contact-criar',
           'contact-editar',
           'contact-deletar',
           'checklistsatlight-listar',
           'checklistsatlight-criar',
           'checklistsatlight-editar',
           'checklistsatlight-deletar',
           'checklistcam-listar',
           'checklistcam-criar',
           'checklistcam-editar',
           'checklistcam-deletar'
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
