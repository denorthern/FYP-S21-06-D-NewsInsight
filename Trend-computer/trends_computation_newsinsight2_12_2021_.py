# -*- coding: utf-8 -*-
"""Trends_Computation_newsinsight2/12/2021 .ipynb

Automatically generated by Colaboratory.

Original file is located at
    https://colab.research.google.com/drive/1M67lJklDVfSMe5LXMtcxx919sZpedk-S

libraries
"""

import nltk
import re
from sklearn.feature_extraction.text import CountVectorizer, TfidfVectorizer
from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
import re
from datetime import timedelta, date,datetime
import numpy as np
import threading

"""Drive Mount

"""

import glob
from google.colab import drive
drive.mount('/content/drive') #mount with drive

"""Trend computation

"""

class TrendComputation:

  def daterange(self,start_date, end_date):    # to generate dates  between start date and end date 
     self.start_date=start_date
     self.end_date=end_date 
     for n in range(int ((end_date - start_date).days)):
        yield start_date + timedelta(n)



####################3
  def helper(self,source,start_date,end_date):   #to store results from trend compute to desired place
        self.source=source
        self.start_date = start_date
        self.end_date = end_date
        #print('days[[[[[[[[[[[[[',numOfDays)
        numOfDays=1
        i=0
        temp1=1   # to find trends according to input num of days e.f 1 4,3 7 
        for single_date in self.daterange(start_date, end_date):                    # for trends time i.e daily , wekly, monthly etc
            #  t1=TrendComputation()   #object of class
              aa=single_date.strftime("%Y-%m-%d")       #date to this formate for unique/symmetic pattern
              bb=end_date.strftime("%Y-%m-%d")
              #print('dateeeeeeeeeeeeeeeeeeee',aa)    #check if date converted into right formte or not
              #print('dateeeeeeeeeeeeeeeeeeee',bb)     #check if date converted into right formte or not
              trends=[]
              freqArray,tdidfArray,trendsArray=self.readData(source,aa)   # pass start date source and end date to compute trends and store to write in desired path
              #print('================================',trendsArray,"--------------------------------------------------------",single_date)
              dict = {'trends': trendsArray, 'tfidf':freqArray ,'frequency':tdidfArray}   # write dict to db
              df = pd.DataFrame(dict) 
              #print('i=>',i)
              if(source!='all'):  #write outputs of dict to file
                 with open('/content/drive/MyDrive/data2/Trends/'+ source +'/'+ str(single_date)  +'--'+ str(numOfDays) +'.csv', 'a',) as f:
                   df.to_csv(f,header=f.tell()==0) 
                   print(source,'-----> ',single_date)
              else:
                 with open('/content/drive/MyDrive/data2/Trends/'+ source +'/'+ str(single_date)  +'--'+ str(numOfDays) +'.csv', 'a',) as f:
                   df.to_csv(f,header=f.tell()==0)
                   print(source,'======>',single_date)                 
           #temp1=temp1+1

########33

  def readData(self,source,start_date): 
     
     worldwide = [ "sputnik", "xinhua","tass","scmp","NYT","dawn","tribune","toi"]   #if ant to calculate trends in combinations all possible sources
     pakistan=[ "dawn","tribune"]
     india= [ "toi"]
     russia=[ "sputnik","tass"]
     china=[ "xinhua","scmp"]
     america=[ "NYT"]

     self.source=source
     self.start_date=start_date
     #self.end_date=end_date
     #self.days=days
     start_date = datetime.strptime(start_date, '%Y-%m-%d').date()
     #end_date = datetime.strptime(end_date, '%Y-%m-%d').date()     
     tempcorpus = []  # make corpus for td idf
     #tempdata=""
     tempdaycounter=0  # counter to comapre it with dates i.e 1,3 5 etc
     #tempdata2=""
     #tempdata3=""
     if(source=='pakistan'):
        multiplesource=pakistan
        source='multiple'
     if(source=='india'):
        multiplesource=india
        source='multiple'        
     if(source=='china'):
        multiplesource=china
        source='multiple'
     if(source=='russia'):
        multiplesource=russia
        source='multiple'
     if(source=='america'):
        multiplesource=america
        source='multiple'  
     if(source=='worldwide'):
        multiplesource=worldwide
        source='multiple'   


     if(source=='multiple'):    # code for trends in combination multiple sources
        for ii in range(len(multiplesource)):   # making corpus
               date=(start_date.strftime("%Y-%m-%d"))
               #print(multiplesource[ii] ,'------------------------------',single_date.strftime("%Y-%m-%d"))
               col_list = ["NER"]
               try:

                 text=pd.read_csv('/content/drive/MyDrive/data3/'+ multiplesource[ii] +'/'+ date +'.csv' , usecols=col_list)
                 print(date,'======',multiplesource[ii])
                 for i in range(len(text)):
                   temp1 = ' '.join([str(elem) for elem in text.iloc[i]])
                   tempcorpus.append(temp1) 
               except IOError:
                print('data for ',date,' not found')

        txt1= pd.DataFrame(tempcorpus)         
        tempdata=self.removeNoise(txt1)
        #print("=====================")
        #tempdata1 =' '.join([str(elem) for elem in tempdata]) 
        tempdata2=self.corpusadd(tempdata)   # add all txts to generate corpus
        tempdata3,tempdata4,tempdata5=self.tfidf(tempdata2)      # calculate tf-idf for given corpus
     else:   
       date=(start_date.strftime("%Y-%m-%d"))                                          # code for trends in combination single sources
       col_list = ["NER"]  #read ners only from csv
       try:
         print(date,'======',source)
         text=pd.read_csv('/content/drive/MyDrive/data3/'+ source +'/'+ date +'.csv' , usecols=col_list)
         for i in range(len(text)):
           temp1 = ' '.join([str(elem) for elem in text.iloc[i]])
           tempcorpus.append(temp1) 
       except IOError:
         print('data for ',date,' not found')
                 
     txt1= pd.DataFrame(tempcorpus)         #store data in pandas dataframe
     tempdata=self.removeNoise(txt1)        # remove some noise i.e \n
     tempdata2=self.corpusadd(tempdata)    #add all data to one  corpus
     tempdata3,tempdata4,tempdata5=self.tfidf(tempdata2)  #calculate tf idf for thaat data
     return tempdata3 ,tempdata4 ,tempdata5

  #def sizeData(self,)
    # size=len(txt1)
    # return size

  def removeNoise(self,text):   # if there is any noise in our case \n is used earlier for name entities trends so remove it
    self.text=text
    txt2=text.replace(r'\n', ',', regex=True)
    return txt2

  def corpusadd(self,text):    # add corpus for selected time to generate tfidf for it , first we need to make corpus 
    self.text=text
    corpus1 = []
    for i in range(len(text)):
      temp1 = ' '.join([str(elem) for elem in text.iloc[i]])
      corpus1.append(temp1)
    return corpus1  

  def tfidf(self,corpus):   # caculate term frequency and inverse document frequency
    self.corpus=corpus
    re_exp = r","
    vectorizer = TfidfVectorizer(tokenizer=lambda text: re.split(re_exp,text) ,lowercase=False)  # lower case true to make U.S to us i.e both count same not different

    X = vectorizer.fit_transform(corpus)  

    counter=np.zeros(len(vectorizer.get_feature_names())) #  for tf idf values
    counterFrequency=np.zeros(len(vectorizer.get_feature_names())) #for frequemcy of ners
    for i in range(len(corpus)):
      tempArray=X[i].toarray()  #it will store unique ners 
      for j in range(len(vectorizer.get_feature_names())):
        if(tempArray[0][j]!=0):
           counter[j]=counter[j]+ tempArray[0][j]  #can add late but adding tf idf value 
           counterFrequency[j]=counterFrequency[j]+ 1
    trends=[]   # for store trends freq
    trendstfidf=[] # for tf id value 
    temparray1=vectorizer.get_feature_names() # feature array having value greater than 1 are trends
    #print('frequency------------------',counterFrequency)
    #print('tfidf value ---------------',counter)
    #print('==========',temparray1)
    freq=[]  #  store freq in db
    tfidfvalue=[]  # store tf idfvalue
    n =len(counter)
    indices = (-counter).argsort()[:n]
    for i in range(len(indices)):
        j=indices[i]
        trends.append(temparray1[j])
        tfidfvalue.append(counter[j])
        freq.append(counterFrequency[j])
        #print("------",counter[j])    #debugging for tf idf value
    return tfidfvalue, freq ,trends

# start_date = date(2021,3,14)    #  start date from which treb=nds need to be calculated
# end_date = date(2021,3,17) 
# dawn=TrendComputation()
# tribune=TrendComputation() 
# pakistan=TrendComputation()
# t5=threading.Thread(target=dawn.helper, args=('dawn',start_date,end_date ))
# t7=threading.Thread(target=tribune.helper, args=('tribune',start_date,end_date ))
# t10=threading.Thread(target=pakistan.helper, args=('pakistan',start_date,end_date ))

# t5.start()
# t7.start()
# t10.start()
# t5.join()
# t7.join()
# t10.join()

######################################daily###########
# start_date = date(2021,10,6)    #  start date from which treb=nds need to be calculated
# end_date = date(2021,11,1)      # end date to which trends need to be calculated
# dawn=TrendComputation()

start_date = date(2021,3,30)    #  start date from which treb=nds need to be calculated
end_date = date(2021,7,7)       # end date to which trends need to be calculated
tribune=TrendComputation() 
t7=threading.Thread(target=tribune.helper, args=('tribune',start_date,end_date ))


t7.start()


t7.join()



start_date = date(2021,12,1)    #  start date from which treb=nds need to be calculated
end_date = date(2021,12,23)      # end date to which trends need to be calculated
numOfDays=1  # trends for how many number of days i.e weekly daily monthly etc

######################################daily###########
tass=TrendComputation()
toi=TrendComputation() #class object
nyt=TrendComputation()
dawn=TrendComputation()
tribune=TrendComputation() 
tass=TrendComputation()  #class object
scmp=TrendComputation()
sputnik=TrendComputation()
xinhua=TrendComputation()
worldwide=TrendComputation()
pakistan=TrendComputation()
india=TrendComputation()
china=TrendComputation()
india=TrendComputation()
america=TrendComputation()

t1=threading.Thread(target=tass.helper, args=('tass',start_date,end_date ))
t2=threading.Thread(target=scmp.helper, args=('scmp',start_date,end_date ))
t3=threading.Thread(target=xinhua.helper, args=('xinhua',start_date,end_date ))
t4=threading.Thread(target=sputnik.helper, args=('sputnik',start_date,end_date ))
t6=threading.Thread(target=nyt.helper, args=('NYT',start_date,end_date ))
t5=threading.Thread(target=dawn.helper, args=('dawn',start_date,end_date ))
t7=threading.Thread(target=tribune.helper, args=('tribune',start_date,end_date ))
t8=threading.Thread(target=toi.helper, args=('toi',start_date,end_date ))
t9=threading.Thread(target=worldwide.helper, args=('worldwide',start_date,end_date ))

t10=threading.Thread(target=worldwide.helper, args=('pakistan',start_date,end_date ))
t11=threading.Thread(target=worldwide.helper, args=('india',start_date,end_date ))
t12=threading.Thread(target=worldwide.helper, args=('china',start_date,end_date ))
t13=threading.Thread(target=worldwide.helper, args=('america',start_date,end_date ))
t14=threading.Thread(target=worldwide.helper, args=('russia',start_date,end_date ))

t1.start()
t2.start()
t3.start()
t4.start()
t5.start()
t6.start()
t7.start()
t8.start()
t9.start()
t10.start()
t11.start()
t12.start()
t13.start()
t14.start()

t1.join()
t2.join()
t3.join()
t4.join()
t5.join()
t6.join()
t7.join()
t8.join()
t9.join()
t10.join()
t11.join()
t12.join()
t13.join()
t14.join()



"""Main body --Daily trends

"""



"""Weekly

"""

# start_date = date(2021,3,14)    #  start date from which treb=nds need to be calculated
# end_date = date(2021,10,26)      # end date to which trends need to be calculated
# numOfDays=7  # trends for how many number of days i.e weekly daily monthly etc

# ######################################daily###########
# tass=TrendComputation()
# toi=TrendComputation() #class object
# nyt=TrendComputation()
# dawn=TrendComputation()
# tribune=TrendComputation() 
# tass=TrendComputation()  #class object
# scmp=TrendComputation()
# sputnik=TrendComputation()
# xinhua=TrendComputation()
# worldwide=TrendComputation()
# pakistan=TrendComputation()
# india=TrendComputation()
# china=TrendComputation()
# india=TrendComputation()
# america=TrendComputation()

# t1=threading.Thread(target=tass.helper, args=('tass',start_date,end_date ))
# t2=threading.Thread(target=scmp.helper, args=('scmp',start_date,end_date ))
# t3=threading.Thread(target=xinhua.helper, args=('xinhua',start_date,end_date ))
# t4=threading.Thread(target=sputnik.helper, args=('sputnik',start_date,end_date ))
# t6=threading.Thread(target=nyt.helper, args=('NYT',start_date,end_date ))
# t5=threading.Thread(target=dawn.helper, args=('dawn',start_date,end_date ))
# t7=threading.Thread(target=tribune.helper, args=('tribune',start_date,end_date ))
# t8=threading.Thread(target=toi.helper, args=('toi',start_date,end_date ))
# t9=threading.Thread(target=worldwide.helper, args=('worldwide',start_date,end_date ))

# t10=threading.Thread(target=worldwide.helper, args=('pakistan',start_date,end_date ))
# t11=threading.Thread(target=worldwide.helper, args=('india',start_date,end_date ))
# t12=threading.Thread(target=worldwide.helper, args=('china',start_date,end_date ))
# t13=threading.Thread(target=worldwide.helper, args=('america',start_date,end_date ))
# t14=threading.Thread(target=worldwide.helper, args=('russia',start_date,end_date ))

# t1.start()
# t2.start()
# t3.start()
# t4.start()
# t5.start()
# t6.start()
# t7.start()
# t8.start()
# t9.start()
# t10.start()
# t11.start()
# t12.start()
# t13.start()
# t14.start()


# t1.join()
# t2.join()
# t3.join()
# t4.join()
# t5.join()
# t6.join()
# t7.join()
# t8.join()
# t9.join()
# t10.join()
# t11.join()
# t12.join()
# t13.join()
# t14.join()

"""Monthly"""

# start_date = date(2021,3,14)    #  start date from which treb=nds need to be calculated
# end_date = date(2021,10,26)      # end date to which trends need to be calculated
# numOfDays=30  # trends for how many number of days i.e weekly daily monthly etc

# ######################################daily###########
# tass=TrendComputation()
# toi=TrendComputation() #class object
# nyt=TrendComputation()
# dawn=TrendComputation()
# tribune=TrendComputation() 
# tass=TrendComputation()  #class object
# scmp=TrendComputation()
# sputnik=TrendComputation()
# xinhua=TrendComputation()
# worldwide=TrendComputation()
# pakistan=TrendComputation()
# india=TrendComputation()
# china=TrendComputation()
# india=TrendComputation()
# america=TrendComputation()

# t1=threading.Thread(target=tass.helper, args=('tass',start_date,end_date ))
# t2=threading.Thread(target=scmp.helper, args=('scmp',start_date,end_date ))
# t3=threading.Thread(target=xinhua.helper, args=('xinhua',start_date,end_date ))
# t4=threading.Thread(target=sputnik.helper, args=('sputnik',start_date,end_date ))
# t6=threading.Thread(target=nyt.helper, args=('NYT',start_date,end_date ))
# t5=threading.Thread(target=dawn.helper, args=('dawn',start_date,end_date ))
# t7=threading.Thread(target=tribune.helper, args=('tribune',start_date,end_date ))
# t8=threading.Thread(target=toi.helper, args=('toi',start_date,end_date ))
# t9=threading.Thread(target=worldwide.helper, args=('worldwide',start_date,end_date ))

# t10=threading.Thread(target=worldwide.helper, args=('pakistan',start_date,end_date ))
# t11=threading.Thread(target=worldwide.helper, args=('india',start_date,end_date ))
# t12=threading.Thread(target=worldwide.helper, args=('china',start_date,end_date ))
# t13=threading.Thread(target=worldwide.helper, args=('america',start_date,end_date ))
# t14=threading.Thread(target=worldwide.helper, args=('russia',start_date,end_date ))

# t1.start()
# t2.start()
# t3.start()
# t4.start()
# t5.start()
# t6.start()
# t7.start()
# t8.start()
# t9.start()
# t10.start()
# t11.start()
# t12.start()
# t13.start()
# t14.start()


# t1.join()
# t2.join()
# t3.join()
# t4.join()
# t5.join()
# t6.join()
# t7.join()
# t8.join()
# t9.join()
# t10.join()
# t11.join()
# t12.join()
# t13.join()
# t14.join()

#  lk
# start_date = date(2021,3,14)    #  start date from which treb=nds need to be calculated
# end_date = date(2021,7,22)      # end date to which trends need to be calculated
# numOfDays=1   # trends for how many number of days i.e weekly daily monthly etc

# ######################################daily###########
# source='tass' 
# tass=TrendComputation()
# tass.helper(source,start_date,end_date,numOfDays)


# source='xinhua' 
# xinhua=TrendComputation()
# xinhua.helper(source,start_date,end_date,numOfDays)

# source='sputnik' 
# sputnik=TrendComputation()
# sputnik.helper(source,start_date,end_date,numOfDays)

# source='scmp' 
# scmp=TrendComputation()
# scmp.helper(source,start_date,end_date,numOfDays)

# source='all' 
# all=TrendComputation()
# all.helper(source,start_date,end_date,numOfDays)

#start_date = date(2021,3,14)    #  start date from which treb=nds need to be calculated
#end_date = date(2021,7,22)      # end date to which trends need to be calculated
#numOfDays=7   # trends for how many number of days i.e weekly daily monthly etc

######################################daily###########
#source='tass' 
#tass=TrendComputation()
#tass.helper(source,start_date,end_date,numOfDays)


#source='xinhua' 
#xinhua=TrendComputation()
#xinhua.helper(source,start_date,end_date,numOfDays)

#source='sputnik' 
#sputnik=TrendComputation()
#sputnik.helper(source,start_date,end_date,numOfDays)

#source='scmp' 
#scmp=TrendComputation()
#scmp.helper(source,start_date,end_date,numOfDays)

#source='all' 
#all=TrendComputation()
#all.helper(source,start_date,end_date,numOfDays)

# source='xinhua'             
# start_date = date(2021,4,1)    
# end_date = date(2021,5,9)    
# numOfDays=1   
# t2=TrendComputation()
# t2.helper(source,start_date,end_date,numOfDays)

# source='scmp'             
# start_date = date(2021,4,1)    
# end_date = date(2021,5,9)    
# numOfDays=1   
# t2=TrendComputation()
# t2.helper(source,start_date,end_date,numOfDays)

# source='tass'             
# start_date = date(2021,4,1)    
# end_date = date(2021,5,9)    
# numOfDays=1   
# t2=TrendComputation()
# t2.helper(source,start_date,end_date,numOfDays)

