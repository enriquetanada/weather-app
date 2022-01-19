<template>
    <div class="weather-bg">
        <b-container> 
            <b-row class="justify-content-center pt-4">
                <h4>Weather App</h4>
            </b-row>
            <b-row>
                <b-col>
                <b-form @submit="onSubmit" >
                    <b-form-group
                        label="Enter City:"
                        label-for="input-1"
                    >
                        <b-form-input
                        id="input-1"
                        v-model="city"
                        type="text"
                        placeholder="Enter city"
                        required
                        ></b-form-input>
                    </b-form-group>
                    <b-button type="submit" variant="primary">Submit</b-button>
                </b-form>
                </b-col>
            </b-row>
            <b-row v-if="is_loading">
                <div class="weather-loader"></div>
            </b-row>
            <b-row cols-lg="4" cols-md="2" cols="1" class="mt-5" v-if="!is_loading">
                <b-col v-for="(f, index) in forecasts" :key="index" class="mb-2">
                    <b-card
                        :title="changeDateFormat(f.date)"
                        :img-src="f.weather == 'Snow' ? '/images/snow.gif' :
                                  f.weather == 'Clouds' ? '/images/cloud.gif' :
                                  f.weather == 'Rain' ? '/images/rain.gif' : 
                                  f.weather == 'Clear' ? '/images/sun.gif' : 
                                   '/images/windy.gif' "
                        img-alt="Image"
                        img-top
                        class="mb-1 text-center"
                    >
                        <b-card-text>
                            <b-row cols="2">
                                <b-col>Min Temp</b-col>
                                <b-col>{{f.min_temp}} °C</b-col>
                            </b-row>
                            <b-row cols="2">
                                <b-col>Max Temp</b-col>
                                <b-col>{{f.max_temp}} °C</b-col>
                            </b-row>
                            <b-row cols="2">
                                <b-col>Feels like</b-col>
                                <b-col>{{f.feels_like}} °C</b-col>
                            </b-row>
                            <b-row cols="2">
                                <b-col>Wind Speed</b-col>
                                <b-col>{{f.wind_speed}} m/s</b-col>
                            </b-row>
                            <b-row cols="2">
                                <b-col>Precipitation</b-col>
                                <b-col>{{(f.pop * 100).toFixed(2)}} %</b-col>
                            </b-row>
                        </b-card-text>

                    </b-card>
                </b-col>

            </b-row>

        </b-container>
    </div>
</template>

<script>
import moment from 'moment';
    export default {
        data(){
            return {
                city:"",
                forecasts: [],
                is_loading: true,
            }
        },
        created(){
            
            this.onCreated(this.city);
        },
         
        methods:{
            onCreated(city) {
                this.is_loading = true;
                this.$query('getWeather', {
                    city: city,
                }).then(res =>{
                    this.is_loading = false;
                    let response = res.data.data.getWeather
                    if(response.error) this.$swal('Error', response.message, 'error');
                    else {
                        response.forecasts.shift();
                        this.forecasts = response.forecasts;
                    }
                })
            },
            onSubmit(e) {
                e.preventDefault()
                this.is_loading = true;
                this.onCreated(this.city)
            },
            changeDateFormat(date){
               return moment(String(date)).format('MMMM DD, YYYY')
            }
        }
    }
</script>
