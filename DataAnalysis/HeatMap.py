from Polygon import Polygon

labeledImages = 1;

class HeatMap:

    def __init__(self, fileName):
        self.polygon = Polygon(fileName)
        self.heat = self.getHeat(self.polygon)

    def getHeat(self, polygon):
        ''' do the intelligence here '''
        

    
    def __init__(self, image_number):
        self.files = []
        

    def process_images():
        for file in self.files:
            with open(file) as f:
                json_str = f.readline()
                
            
        


if __name__ == '__main__':
    numImages = {}
    #TODO: need to backtrack recursively for all combinations
    for imageNumber in range(0, 11):
        files = []
        with open("resultsBlurred.txt") as f:
            content = f.readlines()
        for line in content:
            if line.startswith("Image" +
                               str(imageNumber) + "-") is True:
                files.append(line.strip('\n'))
                polygon = Polygon("../results/BlurredContours/" + line.strip('\n'))
#        print(files)

    #    heat_map.process_images()
