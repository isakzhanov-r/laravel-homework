<template>
    <v-card v-if="weather.hasOwnProperty('fact')" class="md-card-weather">
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title class="headline">Брянск</v-list-item-title>
                <v-list-item-subtitle v-if="'condition' in weather.fact">{{ getCondition(weather.fact.condition) }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-card-text>
            <v-row align="center">
                <v-col class="display-3" cols="6">
                    {{ weather.fact.temp }}&deg;C
                </v-col>
                <v-col cols="6" v-if="'icon' in weather.fact">
                    <v-img
                            :src="getIcon()"
                            width="92"
                    ></v-img>
                </v-col>
            </v-row>
        </v-card-text>
        <v-list-item>
            <v-list-item-icon>
                <v-icon>send</v-icon>
            </v-list-item-icon>
            <v-list-item-subtitle>{{ weather.fact.wind_speed }} km/h</v-list-item-subtitle>
        </v-list-item>
        <v-card-actions>
            <div class="stats">
                <v-icon>date_range</v-icon>
                {{ getDate(weather.fact.obs_time) }}
            </div>
            <v-spacer/>
            <v-btn icon @click="show = !show">
                <v-icon>{{ show ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}</v-icon>
            </v-btn>
        </v-card-actions>

        <v-expand-transition>
            <div v-show="show">
                <v-divider/>
                <v-card-text>
                    <p>Ощущаемая температура: <b v-text="weather.fact.feels_like"/>(°C).</p>
                    <br>
                    <p>Температура воды : <b v-text="weather.fact.temp_water"/> (°C).</p>
                    <br>
                    <p>Скорость порывов ветра: <b v-text="weather.fact.wind_gust"/> (в м/с).</p>
                </v-card-text>
            </div>
        </v-expand-transition>
    </v-card>
</template>

<script>
    export default {
        name: 'WeatherWidget',
        data: () => ({
            weather: [],
            show: false
        }),
        created() {
            this.getWeather();
        },
        methods: {
            getWeather() {
                axios.get('/api/weather/yandex')
                    .then(response => {
                        this.weather = response.data;
                    });
            },
            getIcon() {
                if (this.weather) {
                    var url = 'https://yastatic.net/weather/i/icons/blueye/color/svg/';
                    return url + this.weather.fact.icon + '.svg';
                }
                return null;
            },
            getDate(timestamp) {
                var date = new Date(timestamp * 1000);
                return date.toLocaleString('ru-RU');
            },
            getCondition(condition) {
                var array = {
                    'clear': '— ясно',
                    'partly-cloudy': '— малооблачно',
                    'cloudy': '— облачно с прояснениями',
                    'overcast': '— пасмурно',
                    'partly-cloudy-and-light-rain': '— небольшой дождь',
                    'partly-cloudy-and-rain': '— дождь',
                    'overcast-and-rain': '— сильный дождь',
                    'overcast-thunderstorms-with-rain': '— сильный дождь, гроза',
                    'cloudy-and-light-rain': '— небольшой дождь',
                    'overcast-and-light-rain': '— небольшой дождь',
                    'cloudy-and-rain': ' — дождь',
                    'overcast-and-wet-snow': '— дождь со снегом',
                    'partly-cloudy-and-light-snow': '— небольшой снег',
                    'partly-cloudy-and-snow': '— снег',
                    'overcast-and-snow': '— снегопад',
                    'cloudy-and-light-snow': '— небольшой снег',
                    'overcast-and-light-snow': '— небольшой снег',
                    'cloudy-and-snow': '— снег'
                };
                return array[condition];
            }
        }
    };
</script>

<style scoped>

</style>
