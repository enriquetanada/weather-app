<template>
    <div class="weather-bg">
        <b-container> 
            <b-row class="pt-4 align-items-left">
                <b-col >
                    <b-form @submit="onSubmit">
                        <b-form-group
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
                        <b-button type="submit" variant="primary" >Submit</b-button>
                    </b-form>
                </b-col>
            </b-row>
            <b-row v-if="is_loading">
                <div class="weather-loader"></div>
            </b-row>
            <b-row class="justify-content-center " v-if="!is_loading">
                <h3>{{city ? city: 'Tokyo'}} Weather Details</h3>
            </b-row>
            <b-row cols-lg="4" cols-md="2" cols="1" class="mt-5 d-md-flex d-none" v-if="!is_loading">
                <b-col v-for="(f, index) in forecasts" :key="index" class="mb-2">
                    <b-card
                        :title="changeDateFormat(f.date)"
                        :img-src="f.weather == 'Snow' ? '/images/snow.gif' :
                                  f.weather == 'Clouds' ? '/images/clouds.gif' :
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
            <b-row class="justify-content-center d-md-flex d-none"  v-if="!is_loading">
                <h3>Places Near {{city ? city: 'Tokyo'}}</h3>
            </b-row>
            <b-row cols-lg="4" cols-md="2" cols="1" class="mt-5 d-md-flex d-none" v-if="!is_loading">
                <b-col v-for="(p, index) in places" :key="index" class="mb-2">
                    <b-card
                        :title="p.name"
                        :img-src="p.image"
                        img-alt="Image"
                        img-top
                        class="mb-1 text-center weather-card"
                    >
                        <b-card-text>
                            <b-row cols="2">
                                <b-col>Address</b-col>
                                <b-col>{{p.address}}</b-col>
                            </b-row>
                        </b-card-text>
                    </b-card>
                </b-col>

            </b-row>
           
            <b-row v-if="!is_loading" class="d-md-none d-sm-block justify-content-center mb-3">
                <b-carousel
                    id="carousel-1"
                    :interval="4000"
                    controls
                    indicators
                    background="#ababab"
                    img-width="1024"
                    img-height="800"
                    >
                    <div v-for="(f, index) in forecasts" :key="index">
                        <b-carousel-slide>
                            <template #img>
                                <img
                                    class="d-block img-fluid w-100"
                                    width="1024"
                                    height="480"
                                    :src="f.weather == 'Snow' ? '/images/snow.gif' :
                                    f.weather == 'Clouds' ? '/images/clouds.gif' :
                                    f.weather == 'Rain' ? '/images/rain.gif' : 
                                    f.weather == 'Clear' ? '/images/sun.gif' : 
                                    '/images/windy.gif' "
                                    alt="image slot"
                                >
                                
                                <b-row class="justify-content-center">
                                    <h6>{{changeDateFormat(f.date)}}</h6>
                                </b-row>
                                <b-row cols="2"> 
                                    <b-col class="px-5"><img src="/images/down.png" alt="Min Temp"></b-col>
                                    <b-col>{{f.min_temp}} °C</b-col>
                                </b-row>
                                <b-row cols="2">
                                    <b-col class="px-5"><img src="/images/up.png" alt="Max Temp"></b-col>
                                    <b-col>{{f.max_temp}} °C</b-col>
                                </b-row>
                                <b-row cols="2">
                                    <b-col class="px-5"><img src="/images/temp.png" alt="Feels like"></b-col>
                                    <b-col>{{f.feels_like}} °C</b-col>
                                </b-row>
                                <b-row cols="2">
                                    <b-col class="px-5"><img src="/images/wind.png" alt="Wind Speed"></b-col>
                                    <b-col>{{f.wind_speed}} m/s</b-col>
                                </b-row>
                                <b-row cols="2">
                                    <b-col class="px-5"><img src="/images/rain.png" alt="Precipitation"></b-col>
                                    <b-col>{{(f.pop * 100).toFixed(2)}} %</b-col>
                                </b-row>
                            </template>
                        </b-carousel-slide>
                    </div>
                </b-carousel>
            </b-row>
            <b-row class="d-md-none d-sm-block justify-content-center mb-3"  v-if="!is_loading">
                <h3>Places Near {{city ? city: 'Tokyo'}}</h3>
            </b-row>
            
             <b-row v-if="!is_loading" class="d-md-none d-sm-block justify-content-center">
                <b-carousel
                    id="carousel-1"
                    :interval="4000"
                    controls
                    indicators
                    background="#ababab"
                    img-width="1024"
                    img-height="800"
                    class="mx-5"
                    >
                    <div v-for="(p, index) in places" :key="index" >
                        <b-carousel-slide>
                            <template #img>
                                <img
                                    class="d-block img-fluid w-100"
                                    width="1024"
                                    height="480"
                                    :src="p.image"
                                    alt="image slot"
                                >
                                
                                <b-row class="justify-content-center">
                                    <h6>{{p.name}}</h6>
                                </b-row>
                                <b-row class="justify-content-center"> 
                                    <b-col>Address</b-col>
                                </b-row>
                                <b-row class="justify-content-center">
                                    <b-col>{{p.address}}</b-col>
                                </b-row>
                            </template>
                        </b-carousel-slide>
                    </div>

                    </b-carousel>
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
                        this.places = response.places.splice(0,8)
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
