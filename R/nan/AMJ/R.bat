cd /data/www/html/raindb/R/nan/AMJ/
export PATH=/opt/R-3.0.3/bin:$PATH
echo $PATH
R CMD BATCH Pre-Script.txt
R CMD BATCH KNN.txt
R CMD BATCH SPI.txt
