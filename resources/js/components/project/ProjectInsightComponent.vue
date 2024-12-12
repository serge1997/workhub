<template>
    <div class="col-md-12">
        <h1>Insight by project</h1>
        <Knob v-model="value" valueColor="#34d399" :strokeWidth="5"/>
    </div>
    <div class="col-md-12 p-3 bg-secondary">
        <Chart type="bar" :data="task_count_spints" :options="task_count_spints_bar_options" />
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
                        backgroundColor: ['rgba(249, 115, 22, 0.2)', 'rgba(6, 182, 212, 0.2)', 'rgb(107, 114, 128, 0.2)', 'rgba(139, 92, 246, 0.2)'],
                        borderColor: ['rgb(249, 115, 22)', 'rgb(6, 182, 212)', 'rgb(107, 114, 128)', 'rgb(139, 92, 246)'],
                        borderWidth: 1
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
                            color: "#333"
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: "#333"
                        },
                        grid: {
                            color: "#333"
                        }
                    }
                }
            }
        }

    },
    methods: {
        listCountTaskBySprintsProject(){
            this.Api.get(`bi/count-task-by-sprints/project/${this.projectId}`)
            .then(async response => {
                const results = await response.data;
                for (let data in results){
                    this.task_count_spints.labels.push(results[data].labels);
                    this.task_count_spints.datasets[0].data.push(results[data].task_count)
                }
            })
        }
    },
    mounted(){
        this.listCountTaskBySprintsProject()
    }
}
</script>
