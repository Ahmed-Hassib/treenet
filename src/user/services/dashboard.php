<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <?php if ((base64_decode($_SESSION['sys']['job_title_id']) == 1 || $_SESSION['sys']['change_mikrotik'] == 1) && isset($_GET['msg']) && !empty($_GET['msg']) && $_GET['msg'] == 'mikrotik-ok') { ?>
    <div>
      <div class="alert alert-info w-100%" role="alert">
        <h5 class="alert-heading">
          <i class="bi bi-exclamation-triangle-fill"></i>
          <i class="bi bi-copy"></i>
          <?php echo lang('ATTENTION PLEASE') ?>
        </h5>
        <hr>
        <p>
          <?php echo lang('MIKROTIK VPN CODE', 'pieces') ?>
        </p>
        <?php $company_id = base64_decode($_SESSION['sys']['company_id']) ?>
        <?php $company_name = str_replace_whitespace($_SESSION['sys']['company_name']) ?>
        <div class="code-snippet">
          <header class="code-snippet-header">
            <i class="bi bi-clipboard2 copy-btn" data-target="cmd-1">&nbsp;copy</i>
            <hr>
          </header>
          <pre><code id="cmd-1">/interface sstp-client add connect-to=tree-net.net disabled=no name=<?php echo $company_name ?> password=<?php echo $_SESSION["sys"]["mikrotik"]["password"] ?> user=<?php echo $company_name ?></code></pre>
        </div>
        <p class="my-2" dir="<?php echo $page_dir ?>"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;<?php echo lang('UPDATE MIKROTIK PORT 444', $lang_file) ?></p>
        <div class="code-snippet">
          <header class="code-snippet-header">
            <i class="bi bi-clipboard2 copy-btn" data-target="cmd-2">&nbsp;copy</i>
            <hr>
          </header>
          <pre><code id="cmd-2">/interface eoip add name=<?php echo $company_name . '-eoip' ?> remote-address=199.198.197.1 local-address=<?php echo $_SESSION['sys']['mikrotik']['remote_ip'] ?> tunnel-id=<?php echo intval($company_id) + 1200 ?></code></pre>
        </div>
        <div class="code-snippet">
          <header class="code-snippet-header">
            <i class="bi bi-clipboard2 copy-btn" data-target="cmd-3">&nbsp;copy</i>
            <hr>
          </header>
          <pre><code id="cmd-3">/ip address add address=<?php echo $_SESSION['sys']['mikrotik']['ip_list'] . '/24' ?> network=199.198.197.1 comment=<?php echo $company_name ?> interface=<?php echo $company_name . '-eoip' ?></code></pre>
        </div>
      </div>
    </div>

    <script>
      const copyButtons = document.querySelectorAll('.copy-btn');

      copyButtons.forEach(btn => {
        btn.addEventListener('click', function() {
          // get target text container id
          let target_id = btn.dataset.target;
          // select target element
          let target_el = document.querySelector(`#${target_id}`)
          // get text to copy
          let text_to_copy = target_el.textContent;
          // copy text to clipboard
          copyToClipboard(text_to_copy);
        });
      });

      function copyToClipboard(text) {
        if (!navigator.clipboard) {
          // Clipboard API not supported, use fallback method
          return fallbackCopyToClipboard(text);
        }
        navigator.clipboard.writeText(text)
          .then(() => {
            console.log('Copied to clipboard!');
          })
          .catch(err => {
            console.error('Failed to copy:', err);
          });
      }

      function fallbackCopyToClipboard(text) {
        // Create a hidden textarea element
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();

        try {
          // Try copying using execCommand
          const successful = document.execCommand('copy');
          const msg = successful ? 'Copied!' : 'Failed to copy.';
          console.log(msg);
        } catch (err) {
          console.error('Fallback failed', err);
        }

        // Remove the textarea from the document
        document.body.removeChild(textarea);
      }
    </script>
  <?php } ?>
  <div class="services-container">
    <?php
    if (base64_decode($_SESSION['sys']['job_title_id']) == 1 || $_SESSION['sys']['change_mikrotik'] == 1) {
      // mikrotek info
      include_once 'mikrotik-info.php';
    }
    ?>

    <!-- whatsapp info setting -->
    <?php # include_once 'whatsapp-info.php' 
    ?>

  </div>

  <!-- payment methods -->
  <?php # include_once 'payment-methods.php' 
  ?>
</div>