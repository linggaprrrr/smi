<style>
    #canvas {
        position: absolute;
      }
      #scanned {
        display: flex;
        flex-direction: column;
        gap:1rem;
      }
      #video-wrapper {
        height: 890px;
        position: relative;
        border-radius: 10px;
        overflow: hidden;
      }
</style>
<?= $this->extend('admin/layout/content') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <div class="wrapper">
            <div>
                <div id="video-wrapper">
                    <video id="video" width="360"autoplay></video>
                    <canvas id="canvas" width="0" height="0"></canvas>
                </div>
                <div>
                    <h6>Recently Scanned</h6>
                <div id="scanned"></div>
                </div>
            </div>
        </div>   
        <template id="scaned-item">
        <style>
            .wrapper {
            
            border: none;
            border-radius: 1rem;
            padding: 1rem;
            background: linear-gradient(var(--gradient-start), var(--gradient-end));
            box-shadow: 0 3px -3px 10px #000;
            }
            .wrapper span {
            font-family: Arial, Helvetica, sans-serif;
            
            display: block;
            }
        </style>
        <div class="wrapper">
            <span>Value: <slot name="raw"></slot></span>
        </div>
        </template>
    </div>
    <div class="col-lg-6">
        
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script src="/assets/js/main.js" async></script>
<?= $this->endSection() ?>