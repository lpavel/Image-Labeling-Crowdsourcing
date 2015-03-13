import json
from pprint import pprint

class Polygon:

    def __init__(self, imageName):
        jsonData = open(imageName)
        data = json.load(jsonData)
        self.points = []
        self.edges  = []
        self.allPoints = []
        
#        pprint(data)
        for contour in data:
            pointsInContour = []
            for line in contour:
                pointsInContour.append(( float(line["X"]), float(line["Y"])))
                self.allPoints.append(( float(line["X"]), float(line["Y"])))
            self.points.append(pointsInContour)
#        print(self.points)

        for pointsInContour in self.points:
            edgesInContour = []
            for i in range(1,len(pointsInContour)):
                edgesInContour.append((pointsInContour[i-1], pointsInContour[i]))
            edgesInContour.append((pointsInContour[-1], pointsInContour[0]))
            self.edges.append(edgesInContour)

        self.is_junk()

        if self.junk == True:
            print(imageName)

    def ccw(self,p1,p2,p3):
        p1X, p1Y = p1
        p2X, p2Y = p2
        p3X, p3Y = p3        
        return (p3Y-p1Y) * (p2X-p1X) > (p2Y-p1Y) * (p3X-p1X)
        
    def intersect(self, edge1, edge2):
        p1,p2 = edge1
        p3,p4 = edge2
        return self.ccw(p1,p3,p4) != self.ccw(p2,p3,p4) and self.ccw(p1,p2,p3) != self.ccw(p1,p2,p4)
        
    def is_junk(self):
        intersections = 0
        allEdges = []
        for edgesInContour in self.edges:
            for edge in edgesInContour:
                allEdges.append(edge)
                
#        print('intersections:')
        for i in range(len(allEdges) - 1):
            for j in range(i+2, len(allEdges)):
                if self.intersect(allEdges[i], allEdges[j]) == True:
#                    print('p1:' + str(allEdges[i]) +
#                          'p2:' + str(allEdges[j]))
                    intersections = intersections + 1

        if intersections > 3:
            self.junk = True
        else:
            self.junk = False
#        print(self.junk)
        
if __name__ == '__main__':
    p = Polygon('../results/BlurredContours/Image0-10d2423eac08988b513ebbff7b6cd207.json')
    
