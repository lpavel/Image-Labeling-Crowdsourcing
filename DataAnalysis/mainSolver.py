from BinaryMap import BinaryMap
from HeatMap import HeatMap
from sets import Set
from CacheLoader import CacheLoader
from itertools import combinations

imageNumber = 0
#TODO: make a convention out of this
truthFileName = '../results/GroundTruths/GroundTruth-'

if __name__ == '__main__':
    # this thing can be automated for all images
    cacheLoader = CacheLoader(imageNumber)
    binaryMaps  = cacheLoader.binaryMaps
    heatMap = HeatMap(binaryMaps)
    heatMap.createBinaryFromHeat()
    groundTruthMap = BinaryMap(truthFileName + str(imageNumber) + '.json')
    #print(groundTruthMap.interiorPoints)
    accuracy = heatMap.binaryMap.compareBinaryMaps(groundTruthMap)

    print(accuracy)

    
    '''
    # here will be the code for number of hits for accuracy
    # this code runs
    accuracies = []
    for i in range(len(binaryMaps)):
        totalAccuracy = 0
        for subset in combinations(range(len(binaryMaps)), i):
            binaryMapsSubset = []
            for j in subset:
                binaryMapsSubset.append(binaryMaps[j])
            heatMap = HeatMap(binaryMapsSubset)
            totalAccuracy += heatMap.compareBinaryMaps(groundTruthMap)
        accuracies.append(totalAccuract / i)

    print(accuracies)        
    '''

    '''
    # this script will run all of them at ones

    accuracies = []
    for imageNumber in range(10):
        binaryMaps = CacheLoader(imageNumber)
        heatMap = HeatMap(binaryMaps)
        groundTruthMap = BinaryMaps(truthFileName + str(imageNumber))
        accuracies.append(heatMap.compareBinaryMaps(groundTruthMap))
    print(accuracies)
    '''
    
