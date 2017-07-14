import {Line} from 'vue-chartjs';
import {watchdogData} from './../../config.js';

export default Line.extend({
	
	mounted(){
		axios.get('/api/v1/watchdog-entries')
		.then(response=>{
			console.log(response);
			this.rows = response.data.data.rows;
			this.labels = response.data.data.labels;
			this.setGraph();
		});

	},
	data(){
		return{
			rows:[],
			lables:[],
		}
	},
	methods:{
		setGraph(){
			this.renderChart({
				labels:this.labels,
				datasets:[{
						label:'My Activities',
						backgroundColor: '#dd4b39',
						data:this.rows,
				}]
			},{responsive:true,maintainAspectRatio:false});
		}
	},

})