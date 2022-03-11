<template>
  <div class="modal fade" id="modal-cropie" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Resolución recomenda {{ config.width }} x {{config.height}}</h5>
          <button type="button" @click="resetImages" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input
            ref="IMGC"
            type="file"
            name="image"
            style="display:none"
            accept="image/*"
            @change="setImage"
          />
          <button @click="$refs['IMGC'].click();" 
                  class="btn btn-primary mb-5" 
                  style="width: 100%"
                  role="button">
                  Cargar imagen
          </button>
          <div class="content">
            <section class="cropper-area" v-if="imgSrc && !cropImg">
              <div class="img-cropper">
                <vue-cropper
                  ref="cropper"
                  :zoomable="false"
                  :aspect-ratio="get_escale"
                  :cropBoxResizable="true"
                  :src="imgSrc"
                /><!--preview=".preview"-->
                
              </div>
              <div class="actions text-center">
                <!-- <a href="#"  role="button"  @click.prevent="zoom(0.2)">Zoom In</a>
                <a href="#"  role="button"  @click.prevent="zoom(-0.2)">Zoom Out</a>
                <a href="#"  role="button"  @click.prevent="move(-10, 0)">Move Left</a>
                <a href="#"  role="button"  @click.prevent="move(10, 0)">Move Right</a>
                <a href="#"  role="button"  @click.prevent="move(0, -10)">Move Up</a>
                <a href="#"  role="button"  @click.prevent="move(0, 10)">Move Down</a>
                <a href="#"  role="button"  @click.prevent="rotate(90)">Rotate +90deg</a>
                <a href="#"  role="button"  @click.prevent="rotate(-90)">Rotate -90deg</a>
                <a ref="fliX" href="#" role="button" @click.prevent="flipX">Flip X</a>
                <a ref="fliY" href="#" role="button" @click.prevent="flipY">Flip Y</a> -->
                <a href="#"  role="button"  @click.prevent="cropImage">Cortar</a>
                <!-- <a href="#"  role="button"  @click.prevent="reset">Reset</a>
                <a href="#"  role="button"  @click.prevent="getData">Get Data</a>
                <a href="#"  role="button"  @click.prevent="setData">Set Data</a>
                <a href="#"  role="button"  @click.prevent="getCropBoxData">Get CropBox Data</a>
                <a href="#"  role="button"  @click.prevent="setCropBoxData">Set CropBox Data</a>
                <a href="#"  role="button"  @click.prevent="showFileChooser">Upload Image</a> -->
              </div>
              <!-- <textarea v-model="data" /> -->
            </section>
            <section class="preview-area text-center">
              <!-- <p>Preview</p>
              <div class="preview"/> -->
              <!-- <p>Cropped Image</p> -->
              <div class="cropped-image">
                <img
                  v-if="cropImg"
                  :src="cropImg"
                  alt="Cropped Image"
                />
                <!-- <div v-else class="crop-placeholder" /> -->
              </div>
            </section>
          </div>
        </div>
          
        
        <div class="modal-footer">
          <button type="button" 
                  class="btn btn-secondary" 
                  @click="resetImages" 
                  data-dismiss="modal">Cancelar
          </button>
          <button type="button" 
                  class="btn btn-success"
                  @click="saveImageSlide()" 
                  v-if="cropImg">Guardar imagen
          </button>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
export default {
    name:"ModalCropie",
     data() {
      return {
        config:{//CONFIGURACION DEL SLIDER
          width: '',
          height: '',
          type: '',//1 desktop, 2 movil
        },
        imgSrc: '',
        cropImg: '',
        data: null,
      };
    },
    computed: {
      get_escale() {
        let result = this.config.width/this.config.height;
        return  parseFloat(result.toFixed(2));
      }
    },
    mounted(){
        this.eventHub.$on('showModalCropie', (config) => {
          if (config.value) {
            let pixels = config.value;
            pixels = pixels.split("x");
            this.config.width = parseInt(pixels[0]);
            this.config.height = parseInt(pixels[1]);
            this.config.type = config.tipo;
          }
          $('#modal-cropie').modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
          
        });
    },
    methods: {
      cropImage() {
        // get image data for post processing, e.g. upload or setting image src
        this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
      },
      flipX() {
        const dom = this.$refs.flipX;
        let scale = dom.getAttribute('data-scale');
        scale = scale ? -scale : -1;
        this.$refs.cropper.scaleX(scale);
        dom.setAttribute('data-scale', scale);
      },
      flipY() {
        const dom = this.$refs.flipY;
        let scale = dom.getAttribute('data-scale');
        scale = scale ? -scale : -1;
        this.$refs.cropper.scaleY(scale);
        dom.setAttribute('data-scale', scale);
      },
      getCropBoxData() {
        this.data = JSON.stringify(this.$refs.cropper.getCropBoxData(), null, 4);
      },
      getData() {
        this.data = JSON.stringify(this.$refs.cropper.getData(), null, 4);
      },
      move(offsetX, offsetY) {
        this.$refs.cropper.move(offsetX, offsetY);
      },
      reset() {
        this.$refs.cropper.reset();
      },
      rotate(deg) {
        this.$refs.cropper.rotate(deg);
      },
      setCropBoxData() {
        if (!this.data) return;
        this.$refs.cropper.setCropBoxData(JSON.parse(this.data));
      },
      setData() {
        if (!this.data) return;
        this.$refs.cropper.setData(JSON.parse(this.data));
      },
      setImage(e) {
        const FILE = e.target.files[0];
        if (FILE.type.indexOf('image/') === -1) {
          //Utils.initNoty(`Por favor seleccione una imagen`, "error");
          this.makeToast('Por favor seleccione una imagen','error')
          return;
        }
        let _URL = window.URL || window.webkitURL;        
        let img = new Image();
        img.src = _URL.createObjectURL(FILE);
        img.config = this.config;
        img.cropie  = this.initCropie;
        img.self = this;
        img.onload = function () {
            if(img.width<img.config.width || img.height<img.config.height) {
              img.self.makeToast('cargue una imagen con la resolución recomendada o superior','error')
              return
            }else if(img.width===img.config.width && img.height===img.config.height) {
              img.cropie(false);
            }else if(img.width>img.config.width || img.height>img.config.height) {
              img.cropie(true);
            }else{
              img.self.makeToast('cargue una imagen con la resolución recomendada o superior','error')
              return; 
            }
        }
      },
      showFileChooser() {
        this.$refs.IMGC.click();
      },
      zoom(percent) {
        this.$refs.cropper.relativeZoom(percent);
      },
      initCropie(bool){
        const READER = new FileReader();
        if (bool) {
          READER.onload = (event) => {
            this.imgSrc = event.target.result;
            this.cropped = READER.result;
            this.$refs.cropper.replace(event.target.result);
          };
          READER.readAsDataURL(this.$refs.IMGC.files[0]);
        }else{
          READER.readAsDataURL(this.$refs.IMGC.files[0]);
          READER.onload = () => {
            this.cropImg = READER.result;
          };
        }
      },
      resetImages(){
        this.$refs.IMGC.files=null
        this.$refs.IMGC.value=null
        this.cropImg=null;
        this.imgSrc=null
      },
      saveImageSlide(){
        $('#modal-cropie').modal('hide');
        let obj = {};
        obj.type = this.config.type;
        obj.image = this.cropImg;
        this.eventHub.$emit('setImage',obj);
        this.resetImages();
      },
      makeToast(message,variant = null) {
            this.$toast(message, {
                type:variant || 'info',
                timeout: 4000
            });
        }
    },
    
}
</script>

<style scoped>
.content {
  display: contents;
  justify-content: space-between;
}
.cropper-area {
  width: 100%;
}
.actions {
  margin-top: 1rem;
}
.actions a {
  display: inline-block;
  padding: 5px 15px;
  background: #0062CC;
  color: white;
  text-decoration: none;
  border-radius: 3px;
  margin-right: 1rem;
  margin-bottom: 1rem;
}
textarea {
  width: 100%;
  height: 100px;
}
.preview-area {
  width: 100%;
}
.preview-area p {
  font-size: 1.25rem;
  margin: 0;
  margin-bottom: 1rem;
}
.preview-area p:last-of-type {
  margin-top: 1rem;
}
.preview {
  width: 100%;
  height: calc(372px * (9 / 16));
  overflow: hidden;
}
.crop-placeholder {
  width: 100%;
  height: 200px;
  background: #ccc;
}
.cropped-image img {
  max-width: 100%;
}
</style>
