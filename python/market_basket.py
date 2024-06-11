# import pandas as pd
# from mlxtend.preprocessing import TransactionEncoder
# from mlxtend.frequent_patterns import apriori

# # Sample dataset
# dataset = [
#     ['milk', 'bread', 'butter'],
#     ['beer', 'bread'],
#     ['milk', 'bread', 'butter', 'beer'],
#     ['bread', 'butter'],
#     ['aloo', 'piyaaz', 'tamater'],
#     ['mirchi', 'piyaaz'],
#     ['aloo', 'piyaaz', 'tamater', 'mirchi'],
#     ['piyaaz', 'tamater'],
# ]

# # Transform the dataset
# te = TransactionEncoder()
# te_ary = te.fit(dataset).transform(dataset)
# df = pd.DataFrame(te_ary, columns=te.columns_)

# # Applying the Apriori algorithm with a lower min_support
# frequent_itemsets = apriori(df, min_support=0.3, use_colnames=True)

# # Sort frequent itemsets in descending order based on support
# frequent_itemsets_sorted = frequent_itemsets.sort_values(by='support', ascending=False)

# print("Frequent Itemsets (Sorted by Support):")
# print(frequent_itemsets_sorted)









from http.server import BaseHTTPRequestHandler, HTTPServer
import json
import pandas as pd
from mlxtend.preprocessing import TransactionEncoder
from mlxtend.frequent_patterns import apriori

class RequestHandler(BaseHTTPRequestHandler):
    def do_POST(self):
        content_length = int(self.headers['Content-Length'])
        post_data = self.rfile.read(content_length)
        data = json.loads(post_data)

        # Transform the dataset
        te = TransactionEncoder()
        te_ary = te.fit(data).transform(data)
        df = pd.DataFrame(te_ary, columns=te.columns_)
        
        # Applying the Apriori algorithm with a lower min_support
        frequent_itemsets = apriori(df, min_support=0.3, use_colnames=True)
        
        # Sort frequent itemsets in descending order based on support
        frequent_itemsets_sorted = frequent_itemsets.sort_values(by='support', ascending=False)
        
        # Convert to JSON
        frequent_itemsets_json = frequent_itemsets_sorted.to_json(orient='records')
        
        # Send response
        self.send_response(200)
        self.send_header('Content-type', 'application/json')
        self.end_headers()
        self.wfile.write(frequent_itemsets_json.encode())

def run(server_class=HTTPServer, handler_class=RequestHandler, port=8000):
    server_address = ('', port)
    httpd = server_class(server_address, handler_class)
    print(f'Starting server on port {port}...')
    httpd.serve_forever()

if __name__ == "__main__":
    run()
