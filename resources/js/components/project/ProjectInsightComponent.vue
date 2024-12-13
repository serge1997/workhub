<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h5>Project tasks data vizualisation</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 p-3">
                <Chart type="bar" :data="task_count_spints" :options="task_count_spints_bar_options" />
            </div>
            <div class="col-md-6 d-flex gap-2 justify-content-start flex-wrap p-5">
                <div>
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-transparent border-0 p-0">
                            <Tag class="fw-normal bg-transparent task-description" value="sprint 1" />
                        </div>
                        <div class="card-body py-1">
                            <Knob v-model="value" readonly valueTemplate="20/30" valueColor="#34d399" :strokeWidth="5"/>
                        </div>
                        <div class="card-footer d-flex flex-column align-items-start bg-transparent border-0 px-2 py-0 mb-1">
                            <span class="d-flex gap-2">
                                <span class="bg-transparent small-fw task-description">concluidas:</span>
                                <Tag class="fw-normal p-1 py-0" severity="success" value="20" />
                            </span>
                            <span class="d-flex gap-2">
                                <span class="bg-transparent small-fw task-description">não concluidas:</span>
                                <Tag class="fw-normal p-1 py-0" severity="warning" value="30" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ProjectInsightComponent',

    props: {
        projectId: Number,
    },
    data(){
        return {
            value: 30,
            task_count_spints: {
                labels: [],
                datasets:[
                    {
                        label: 'Task',
                        data: [],
                        backgroundColor: ['#64748b', '#0ea5e9', '#4f46e5', '#db2777', '#10b981'],
                        borderColor: ['#64748b', '#0ea5e9', '#4f46e5', '#db2777'],
                        borderWidth: 0,
                        borderRadius: 8,
                        barPercentage: 0.3
                    }
                ]
            },
            task_count_spints_bar_options: {
                plugins: {
                    legend: {
                        labels: {
                            color: "#333"
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: "#333"
                        },
                        grid: {
                            color: "#cbd5e1"
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: "#333"
                        },
                        grid: {
                            color: "#cbd5e1"
                        }
                    }
                }
            }
        }

    },
    methods: {
        listCountTaskBySprintsProject(){
            let labelX = [];
            let labelY = [];
            this.Api.get(`bi/count-task-by-sprints/project/${this.projectId}`)
            .then(async response => {
                const results = await response.data;
                for (let data in results){
                    this.task_count_spints.labels.push(results[data].labels);
                    labelY.push(results[data].task_count)
                    labelX.push(results[data].labels)
                }
                this.task_count_spints.labels = labelX;
                this.task_count_spints.datasets[0].data = labelY;
            })
        }
    },
    mounted(){
        this.listCountTaskBySprintsProject()
    }
}
</script>
