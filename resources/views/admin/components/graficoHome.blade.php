<section class="section">
    <div class="row">
        @foreach ($data['array_grafico_enquete'] as $key_vlr => $vlr)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $data['array_grafico_pergunta'][$key_vlr] }}</h5>
                        <!-- Pie Chart -->
                        <div id="pieChart{{ $loop->iteration }}" style="min-height: 400px;" class="echart"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                echarts.init(document.querySelector("{{ '#pieChart' . $loop->iteration }}")).setOption({
                                    title: {
                                        //text: 'Referer of a Website',
                                        //subtext: 'Fake Data',
                                        left: 'center'
                                    },
                                    tooltip: {
                                        trigger: 'item'
                                    },
                                    legend: {
                                        orient: 'vertical',
                                        left: 'left'
                                    },
                                    series: [{
                                        label: {
                                            show: true,
                                            formatter(param) {
                                                // correct the percentage
                                                return param.name + ' (' + param.percent * 1 + '%) ' + param.value +
                                                    ' Votos';
                                            }
                                        },
                                        //name: 'Access From',
                                        type: 'pie',
                                        radius: '70%',
                                        data: {{ Js::from($vlr) }},
                                        emphasis: {
                                            itemStyle: {
                                                shadowBlur: 10,
                                                shadowOffsetX: 0,
                                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                                            }
                                        }
                                    }]
                                });
                            });
                        </script>
                        <!-- End Pie Chart -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
