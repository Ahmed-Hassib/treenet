function create_img_plugin(img_src) {
  // Note: changes to the plugin code is not reflected to the chart, because the plugin is loaded at chart construction time and editor changes only trigger an chart.update().
  const image = new Image();
  image.src = img_src;

  const plugin = {
    id: 'customCanvasBackgroundImage',
    beforeDraw: (chart) => {
      if (image.complete) {
        const ctx = chart.ctx;
        const { top, left, width, height } = chart.chartArea;
        const x = left + width / 2 - image.width / 2;
        const y = top + height / 2 - image.height / 2;
        ctx.drawImage(image, x, y);
      } else {
        image.onload = () => chart.draw();
      }
    }
  };

  return plugin;
}


function create_chart_data(labels, chart_label, data, bg_colors, br_colors) {
  const chart_data = {
    labels: labels,
    datasets: [{
      label: chart_label,
      data: data,
      backgroundColor: bg_colors,
      borderColor: br_colors,
      borderWidth: 1
    }]
  };

  return chart_data;
}

function chart_config(data, chart_type, img_plugin) {
  const config = {
    type: chart_type,
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        },
      },
    },
    plugin: [img_plugin]
  };

  return config;
}

function chart_init(canvas_el, config) {
  let myChart = new Chart(canvas_el, config);
}


