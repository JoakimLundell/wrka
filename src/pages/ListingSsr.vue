<template>
    <main-layout>
        <div id="map"></div>
        
    
        <div class="controls">
            <my-select
                disabled 
                :index="currentCity" 
                :options="citys" 
                v-on:change="selectChange"></my-select>
            <button disabled 
                class="small" 
                v-on:click="nearme">Nära mig</button>
        </div>
     <div v-if="geoError" class="error">{{this.geoError}}</div>
        <div class="resellers">
            <div class="loader" v-if="loading">
                <my-loader type="radial"></my-loader>
            </div>
             
            <transition-group name="fade" v-if="filteredResellers.length > 0"> 
               
                <my-reseller
                     
                    v-for="reseller in filteredResellers"
                    :reseller="reseller" 
                    v-bind:key="reseller.phone" 
                    :active="highlighted"></my-reseller>
                     
            </transition-group>
            <div v-else>
                <p class="box">SäkerhetsBranschen är en förening för säkerhetsföretag med 505 medlemsföretag som tillsammans omsätter 57 miljarder kronor per år och har 33.000 medarbetare.</p>
                <div class="box">Vi kommer snart vara anslutna med våra leverantörer. </div>
            </div>   
        </div>
       
    </main-layout>
</template>

<script>
import MainLayout from '../layouts/Main.vue'
import MySelect from '../components/VSelect.vue'
import MyReseller from '../components/VReseller.vue'
import MyLoader from '../components/VLoader.vue'
import { bus } from '../bus.js'
import tools from '../tools.js'

export default {
    components: {
        MainLayout,
        MySelect,
        MyReseller,
        MyLoader
    },

    data: function () {
        return {
            loading: false,
            citys: [],
            currentCity: null,
            resellers: Array,
            filteredResellers: [],
            map: null,
            tileLayer: null,
            markers: null,
            circle: null,
            highlighted: null,
            geoError: null,
            geoCoords: null,
            optionsDefault: 'Välj ort'
        }
    },

    mounted: function() {
        this.fetchResellers();
        this.initMap();      
    },

    created: function ()  {
        bus.$on('openEvent', eventData => {
            this.highlighted = parseInt(eventData);
            this.showPins();
            this.scrollIntoView();
        })
        bus.$on('resellerClick', id => {
            this.highlighted = parseInt(id);
            this.showPins();
        })
    },

    methods: {
        scrollIntoView() {
            setTimeout(() => {
                let e = this.$el.querySelector("#id" + this.highlighted);
                this.scrollIntoViewIfOutOfView(e);
            }, 500);   
        },

        scrollIntoViewIfOutOfView(el) {
            var topOfPage = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
            var heightOfPage = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
            var elY = 0;
            var elH = 0;
            if (document.layers) { // NS4
                elY = el.y;
                elH = el.height;
            }
            else {
                for(var p=el; p&&p.tagName!='BODY'; p=p.offsetParent){
                elY += p.offsetTop;
                }
                elH = el.offsetHeight;
            }
            if ((topOfPage + heightOfPage) < (elY + elH)) {
                el.scrollIntoView(false);
            }
            else if (elY < topOfPage) {
                el.scrollIntoView({behavior: "smooth"});
            }
        },
     
        nearme () {
            var options = {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            } 
            navigator.geolocation.getCurrentPosition(
            this.geolocationSuccess,
            this.geolocationError, 
            options); 
        },

        geolocationSuccess (position) {
            this.geoError = null;
            this.geoCoords = position.coords;
            this.resetSelect();
            this.showNearest();
        },

        geolocationError (error) {
            console.log("Oooops " + error);
            console.dir(error);
            this.geoError = error.message;
        },

        resetSelect() {
            this.currentCity = this.getSelectDefault();
        },

        getSelectDefault() {
            return this.citys[0];
        },

        showNearest() {
            // clear old circle
            this.circle.clearLayers(this.circle);
            let a;
            let arr = [];
            let p = this.geoCoords;
            this.highlighted = null;
            this.filteredResellers = [];
            
            let coords;

            a = L.circle([p.latitude, p.longitude], {
                radius: 10000
            }).addTo(this.circle);
            this.circle.addTo(this.map);

            this.resellers.forEach(function(customer, index){
                let coords = (customer.latlng).split(',');
                var marker = L.marker([coords[0], coords[1]]);
                if(a.getBounds().contains(marker.getLatLng())){
                    arr.push(customer);
                }
            });
            
            this.myArea = a;
            this.filteredResellers = arr;
            this.showPins();
            this.fitBounds();
        },
 
        fetchResellers () {
            this.loading = true;
            setTimeout(function(){
                let url = 'sakerhetsbranchen.json';
                fetch(url)
                .then(res => res.json())
                .then((json) =>  {
                    this.resellers = json;
                    return json;
                }).then((json) => {
                    return this.createCityOptions(json);
                }).then((a) => {
                    this.citys = a;
                    this.currentCity = a[0]
                    this.loading = false;
                })
                .catch(err => { console.log(err) });
            }.bind(this), 500);
        },

        async createCityOptions (json) {
            return new Promise(resolve => {
                let options = [];
                let data = json
                for (var i = 0; i < data.length; i++) {
                    let city =data[i].city;
                    city = tools.capitalize(city.trim());
                    //city = tools.capitalize()
                    options.push(city);
                }
                var unique = options.filter(tools.onlyUnique).sort();  
                unique.unshift(this.optionsDefault);
                
                resolve(unique);
            });
        },

        selectChange (city) {
            console.log("Ändrar stad...");
            this.highlighted = null
            this.currentCity = city;
            this.resellersByCity();
            this.showPins();
            this.fitBounds();
        },

        resellersByCity () {
            let array = [];
            //let city = this.currentCity.toUpperCase();
            let city = this.currentCity;
            //console.dir(this.resellers); 
            this.resellers.forEach(function(i){
                // trim för att name innehåller blanksteg för säkerhetsbranchen
                if(i.city.trim() === city){
                    array.push(i);  
                }
            });
            //console.log(array.length);
            this.filteredResellers = array;
        },

        initMap () {
            this.map = L.map(map).setView([62.875188, 16.391602], 3);
            this.tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(this.map);

            this.markers = L.featureGroup();
            this.circle = L.featureGroup();
            this.map.zoomControl.setPosition('bottomright');
        },

        showPins() {
            // clear current layer
            this.markers.clearLayers(this.markers);
            
            for(let index in this.filteredResellers) {
                // Bryt ut till funktion?
                let id = parseInt(index) +1;
                let name = id.toString();

                let resellerId = this.filteredResellers[index].id;
            
                var numberIcon = L.divIcon({
                    className: "number-icon",
                    iconSize: [25, 41],
                    iconAnchor: [10, 44],
                    popupAnchor: [3, -40],
                    html: name        
                });

                var numberIconActive = L.divIcon({
                    className: "number-icon-active",
                    iconSize: [25, 41],
                    iconAnchor: [10, 44],
                    popupAnchor: [3, -40],
                    html: name        
                });

                let currentIcon = (resellerId == this.highlighted) 
                    ? numberIconActive 
                    : numberIcon 

                var m = L.marker([
                        this.filteredResellers[index].lat,
                        this.filteredResellers[index].lng
                    ],{ 
                    id: resellerId,
                    icon: currentIcon  
                })
                .addTo(this.markers).on('click', (e) => {
                    console.log("Hi");
                });             
            };
            this.markers.addTo(this.map);
        },

        fitBounds() {
            this.map.fitBounds(this.markers.getBounds().pad(1));
        },
    }
}
   
</script>


<style scoped>
/*.fade-item {
    display: inline-block;
}
.fade-enter-active, .fade-leave-active {
    transition: all 1s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}*/

.loader {
    position: absolute;
    top:35px;
    left:0;
    bottom: 0; right:0;
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background:rgba(218, 220, 221, 0.822);
    z-index: 9999;
}

.controls {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.resellers {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    width: auto;
    padding: 0 12px;
    height: calc(100vh - 379px);/*64 + 280 + 35 */
    overflow-y: auto;
    
}
.error {
    background: red; 
    padding: 6px;
    z-index: 9999;
    width: 100vw
}

    .box {
    width: 45vw;
    padding: 24px;
    }

</style>
 