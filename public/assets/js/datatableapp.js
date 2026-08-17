$(document).ready(function () {
    $('.dataTableAdmin').DataTable({
        // --- Configurações de Performance ---
        responsive: true,
        fixedHeader: true,
        deferRender: true, // Melhora performance em listas longas
        stateSave: true,   // Salva filtros e paginação no navegador do usuário
        
        // --- Layout e Botões ---
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copy', className: 'btn btn-sm btn-warning' },
            { extend: 'csv', className: 'btn btn-sm btn-success-emphasis' },
            { extend: 'excel', className: 'btn btn-sm btn-success' },
            { extend: 'print', className: 'btn btn-sm btn-info' },
            { extend: 'colvis', className: 'btn btn-sm btn-primary' }
        ],

        // --- Tradução Inteligente ---
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
            // Você pode sobrescrever algo específico se desejar:
            searchPlaceholder: "Buscar registros...",
        },

        // FUNÇÃO QUE ALTERA A COR DA LINHA
        rowCallback: function(row, data, index) {
            // 1. Extrai apenas o texto de dentro do HTML da coluna 8
            // Se o Status for a 9ª coluna, o índice é 8. 
            // Se for a 8ª, mude para data[7].
            var statusTexto = $(data[8]).text().trim().toLowerCase();

            // 2. Remove classes antigas para evitar conflitos ao filtrar/paginar
            $(row).removeClass('table-success table-warning table-danger');

            // 3. Aplica a nova cor
            if (statusTexto.indexOf('encerrada') !== -1) {
                $(row).addClass('table-success');
            } 
            else if (statusTexto.indexOf('aguardando') !== -1) {
                $(row).addClass('table-warning');
            }
        },

        // --- Configuração de Colunas (Opcional mas recomendado) ---
        columnDefs: [
            { targets: 0, orderable: false, searchable: false }, // Coluna '#' é só um contador de exibição (Blade), não reflete a ordenação/paginação do DataTables
            { targets: -1, orderable: false, searchable: false }, // Desativa ordenação na coluna 'Ações'
            { className: "dt-center", targets: "_all" } // Centraliza todas as colunas
        ]
    });
});