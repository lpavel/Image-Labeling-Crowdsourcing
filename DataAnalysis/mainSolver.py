from BinaryMap import BinaryMap
from HeatMap import HeatMap
from sets import Set

if __name__ == '__main__':
    content = []
    with open("resultsBlurred.txt") as f:
        content = f.readlines()
    lineNumber = 0
    numImages = content[lineNumber]
    lineNumber += 1
    binaryMaps = []    
    for i in range(1, numImages):
        binaryMapsImage = []
        numAnnotations = content[lineNumber]
        lineNumber += 1
        for j in range(numAnnotations):
            numPoints = content[lineNumber]
            lineNumber += 1
            coords = []
            for k in range(numPoints):
                coord = [int(n) for n in content[lineNumber].split()]
                lineNumber += 1
                coords.append(coord)
            binaryMapsImage = BinaryMap("", coords)
        binaryMaps.append(binaryMapsImage)

    # at this point HeatMap should definitely be doable


    '''
        
    #TODO: need to backtrack recursively for all combinations
    for imageNumber in range(0, 11):
        # very inefficient because the file gets read too many times
        polygonsImage = []
        for line in content:
            if line.startswith("Image" +
                               str(imageNumber) + "-") is True:
                polygon = Polygon("../results/BlurredContours/" + line.strip('\n'))
                if polygon.junk == False:
                    polygonsImage.append(polygon)

        polygons.append(polygonsImage)
    print(polygons)
    #    heat_map.process_images()
    
    '''
