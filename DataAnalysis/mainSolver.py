from BinaryMap import BinaryMap
from HeatMap import HeatMap
from sets import Set
from CacheLoader import CacheLoader
from itertools import combinations

imageNumber = 0

if __name__ == '__main__':
    binaryMaps = CacheLoader(imageNumber)
    l = []

    heatMap = HeatMap()

    '''
    here will be the code for number of hits for accuracy
    for i in range(10):
        for subset in combinations(range(10),i):
            
            print(subset)
    
    '''
