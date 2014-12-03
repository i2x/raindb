cd /data/www/html/raindb/R/chi/JFM/
export PATH=/opt/R-3.0.3/bin:$PATH
R CMD BATCH Pre-Script.txt
R CMD BATCH JFM.txt
R CMD BATCH SPI.txt
