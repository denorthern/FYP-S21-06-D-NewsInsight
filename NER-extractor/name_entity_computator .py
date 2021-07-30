# -*- coding: utf-8 -*-
"""Name Entity Computator.ipynb

Automatically generated by Colaboratory.

Original file is located at
    https://colab.research.google.com/drive/15VlK6pzaXOLRZXIBRG3dSGN6itaREBfH
"""

import pandas as pd 
import threading
import re, string, unicodedata
import nltk
nltk.download('averaged_perceptron_tagger')
import pandas as pd
nltk.download('punkt')
nltk.download('wordnet')
import inflect
from nltk import word_tokenize, sent_tokenize
from nltk.corpus import stopwords
from nltk.corpus import stopwords
nltk.download('stopwords')
from nltk.tokenize import word_tokenize
import re
from nltk.stem import WordNetLemmatizer
lemmatizer = WordNetLemmatizer()
import glob
from nltk.tokenize import word_tokenize
import spacy
from spacy import displacy
from collections import Counter
import en_core_web_sm
nlp = en_core_web_sm.load()

import glob
from google.colab import drive
drive.mount('/content/drive')

class NameEntityComputer:
    
		   
    def text_lowercase(self,text):  # WORD TO word
        self.text=text
        return text.lower()
	
    def remove_numbers(self,text):  #  remove num from text
        self.text=text
        result = re.sub(r'\d+', '', text)
        return result

    def remove_punctuation(self,text):   #remove punctations
        self.text=text
        translator = str.maketrans('', '', string.punctuation)
        return text.translate(translator)

    def remove_whitespace(self,text):   # extra spaces 
        self.text=text
        return  " ".join(text.split())

    def remove_stopwords(self,text):   #unnecessary words like the”, “is”, “in”, “for”
         self.text=text
         all_stopwords = stopwords.words('english')
         sw_list = ['december', 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november',
                     'dec', 'jan', 'feb', 'mar', 'aprl', 'may', 'jun', 'july', 'aug', 'sep', 'oct', 'nov',
                          'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday','sunday','name','students','many',
                         'today','tommorrow','yestersay','last',
                          'mother', 'father', 'baby', 'child', 'toddler', 'teenager', 'grandmother', 'student', 'teacher', 'minister', 'businessperson', 'salesclerk', 'woman', 'man',
                         'table', 'truck', 'book', 'pencil', 'iPad', 'computer', 'coat', 'boots',
                         'city', 'state', 'country', 'continent', 'coffee shop', 'restaurant', 'park', 'zoo',
                         'envy', 'love', 'hate', 'respect', 'patriotism', 'pride','Advertisement'
                         'open','close','online','offline','ever','since','as','according','because','traditionally','immediately',
                     'tweet','read','write','so','area','especially','mix','life','withdraw','ahead','forward','back','backward','add'
                     'subtract','divide','multiply','result','amid','subscribe','wait','officials','first','second','every',
                     'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'
                     ]  #remove unnecessary words i.e some words  preprocessing e.g removes "this,we" but not "This,We" by making all words to lowercase 
         all_stopwords.extend(sw_list)   
         text_tokens = word_tokenize(text)
         tokens_without_sw = [word for word in text_tokens if not word.lower() in all_stopwords]
         return tokens_without_sw

    def lemmatize_word(self,text):    # extraction, extracting to extract
        self.text=text
        word_tokens = word_tokenize(text)
        # provide context i.e. part-of-speech
        lemmas = [lemmatizer.lemmatize(word, pos ='v') for word in word_tokens]
        return lemmas



    def helper(self, nsite):    #read soyrce and split text into article, source , title etc and preprocess article and find ners
        self.nsite = nsite
        myFilesPaths = glob.glob(r'/content/drive/MyDrive/datasets/'+nsite+'/*.txt')  #extratct all links of file from target folder
    
        for i in range(len(myFilesPaths)):
             Article="0"

             f = open(myFilesPaths[i], "r")
             for x in f:
               if (x.find('Source:') != -1):  # for extracting source from txt file
                   x1 = x.split("Source:")
                   Source=x1[1:]
               if (x.find('Link:') != -1):   # for extracting link from txt file
                   x1 = x.split("Link:")
                   Link=x1[1:]
                   Link= ''.join([str(elem) for elem in Link]) 
                   Link=Link.strip()

               if (x.find('DateOfExtraction:') != -1):   # for extracting date of extraction from txt file
                   x1 = x.split("DateOfExtraction:")
                   DateOfExtraction=x1[1:]
               if (x.find('DateOfPublication:') != -1):   # for extracting date of publication from txt file
                   x1 = x.split("DateOfPublication:")
                   DateOfPublication=x1[1:] 
                   DateOfPublication = ' '.join([str(elem) for elem in DateOfPublication])  
                   dop=DateOfPublication.split('-',2)
                   yr=dop[0]              # extra steps to make all dates in unique formate i.e 2021/2/3 to 2021/02/03
                   mth=int(dop[1])
                   dy=int(dop[2])
                   if mth<10:
                     mth1='0'+str(mth)    
                   if mth>=10:
                      mth1=str(mth)
                   if dy<10:
                     dy1='0'+str(dy)  
                   if dy>=10:
                     dy1=str(dy)   
                   #print('-',DateOfPublication)   
                   DateOfPublication=yr+'-'+mth1+'-'+dy1
                   newDateOfPublication=DateOfPublication.strip()
                   #print('-',newDateOfPublication)

               if (x.find('Title:') != -1):  # for extracting title from txt file
                   x1 = x.split("Title:")
                   Title=x1[1:]
                   Title= ''.join([str(elem) for elem in Title])
               if (x.find('Author:') != -1):  # for extracting author from txt file
                   x1 = x.split("Author:")
                   Author=x1[1:]
               else:         
                   #x1 = x.split(":")    # for extracting article from txt file
                   pArticle=x
                   Article=Article + pArticle
             x1 = Article.split("Article:")
             Article=x1[1:]


             Article = ' '.join([str(elem) for elem in Article])              
             Article=Article+Title   # to add ners of title we merge title and article
             Article=re.sub(r'http\S+', '', Article)  # to remove http links if exist

             #print('========================================',Article)  #debugging
             #Article = ' '.join([str(elem) for elem in Article])   #debugging
             #Article=self.text_lowercase(Article)    #debugging
             #Article=self.remove_numbers(Article)    #debugging

             #Article = ' '.join([str(elem) for elem in Article])  #debugging
             #Article=self.remove_punctuation(Article)               #debugging
             Article=self.remove_whitespace(Article)  
             Article=re.sub(r'[^\w]', ' ', Article)   # keep alpha numeric values will match anything that's not alphanumeric or underscore
             Article=self.remove_stopwords(Article)
             #Article = ' '.join([str(elem) for elem in Article])
             #Article=self.lemmatize_word(Article)      #debugging
             Article = ' '.join([str(elem) for elem in Article])  # list to string
             doc = nlp(Article)
             included_labels = ("PERSON","ORG", "EVENT","NORP","GPE" ,"PRODUCT")  # keep only these ners we do not need time etc ners
             DesiredNER = [ent for ent in doc.ents if ent.label_  in included_labels]
             ner0=DesiredNER        
             ner= '\n'.join([str(elem) for elem in ner0])        ###########################  ners by space
             
             # add some nouns that might miss by spacy   #debugging
             #print('=== before removal: ', len(match), " - ",match)   #debugging
             #print('=== Ner: ',ner)    #debugging
             #print(type(match))         #debugging
             #print('link....',Link)      #debugging
             #print('date....',newDateOfPublication)  #debugging
             #print('article....',Article)             #debugging
             AdditionalNouns=[]   #pos tagging for some missied nouns i.e Inzimam
             text=word_tokenize(Article)
             ele=nltk.pos_tag(text)   #nltk part of speech and keep nnp
             for e in ele:
               if e[1]=='NNP':
                 AdditionalNouns.append(e[0])
             duplicates=[]
             for k in AdditionalNouns:
                if k in ner:
                  duplicates.append(k)
             for k in AdditionalNouns:
               for j in ner:     
                ele=j[0].split()
                if len(ele)>1:
                  if k == ele:
                    duplicates.append(k)

             final = [i for i in AdditionalNouns + duplicates if i not in AdditionalNouns or i not in duplicates]
            # print(AdditionalNouns)
            # print(">>>>")

            # print(duplicates)
            # print(">>>>")
            # print(ner)
             #print(">>>>")
             #print(final)
             #print("--------------------------------------")
             final= '\n'.join([str(elem) for elem in final])

             
             #ner=re.sub(r'[^\w]', ' ', ner)    #[^\w] will match anything that's not alphanumeric or underscore

             #ner= '\n'.join([str(elem) for elem in ner])
             #zee= '\n'.join([str(elem) for elem in zee])
             ner=ner + final
             
                #after finding ners store in a dictionary and store for future use 
             dict = {'Source': Source, 'Link': Link, 'DateOfExtraction': DateOfExtraction      
                , 'DateOfPublication': newDateOfPublication, 'Title': Title,
                'Article': Article ,'NER':ner
                }  
       
             #DateOfPublication = ' '.join([str(elem) for elem in DateOfPublication])
             #newDateOfPublication = DateOfPublication.strip()
             #print('---------------------->',DateOfPublication+DateOfPublication)
             df = pd.DataFrame(dict) 
        #with open('/content/drive/MyDrive/Dataset_NameEntityComputer_tass/'+ str(i)+'.csv', 'w') as f:
             with open('/content/drive/MyDrive/Dataset_NameEntityComputer/'+ nsite +'/'+ newDateOfPublication+'.csv', 'a') as f:   # add to drive
               df.to_csv(f,header=f.tell()==0)
               print(nsite,' => ',i,"/",len(myFilesPaths))



toi=NameEntityComputer()  #class object


nyt=NameEntityComputer()


dawn=NameEntityComputer()


tribune=NameEntityComputer()
 

tass=NameEntityComputer()  #class object


scmp=NameEntityComputer()


sputnik=NameEntityComputer()
 

xinhua=NameEntityComputer()


t1=threading.Thread(target=dawn.helper, args=('dawn', ))
t2=threading.Thread(target=nyt.helper, args=('NYT', ))
t3=threading.Thread(target=tribune.helper, args=('tribune', ))
t4=threading.Thread(target=toi.helper, args=('toi', ))

t5=threading.Thread(target=scmp.helper, args=('scmp', ))
t6=threading.Thread(target=tass.helper, args=('tass', ))
t7=threading.Thread(target=sputnik.helper, args=('sputnik', ))
t8=threading.Thread(target=xinhua.helper, args=('xinhua', ))

t1.start()
t2.start()
t3.start()
t4.start()
t5.start()
t6.start()
t7.start()
t8.start()

t1.join()
t2.join()
t3.join()
t4.join()
t5.join()
t6.join()
t7.join()
t8.join()


#Python | Named Entity Recognition (NER) using spaCy https://www.geeksforgeeks.org/python-named-entity-recognition-ner-using-spacy/.  Accessed May 18,2021
#Train Custom NAMED ENTITY RECOGNITION (NER) model using BERT https://www.youtube.com/watch?v=uKPBkendlxw. Accessed May 22,2021
#How to Clean Text for Machine Learning with Python https://machinelearningmastery.com/clean-text-machine-learning-python/. Accessed May 5,2021
#Tf-Idf vectorize https://scikit-learn.org/stable/modules/generated/sklearn.feature_extraction.text.TfidfVectorizer.html. Accessed June12,2021
#Categorizing and POS Tagging with NLTK Python https://medium.com/@muddaprince456/categorizing-and-pos-tagging-with-nltk-python-28f2bc9312c3. Accessed May 10,2021

